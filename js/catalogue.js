// catalogue.js — Chargement et filtrage des jeux depuis l'API

document.addEventListener('DOMContentLoaded', function() {

    var URL_API = '/NEBULA/api/games.php?limit=50';

    var filtreGenres   = document.getElementById('filterGenres');
    var champRecherche = document.getElementById('searchInput');
    var grilleInclus   = document.getElementById('gridIncluded');
    var grilleAchat    = document.getElementById('gridPurchase');
    var compteurInclus = document.getElementById('countIncluded');
    var compteurAchat  = document.getElementById('countPurchase');
    var messageVide    = document.getElementById('noResults');
    var sectionInclus  = document.getElementById('sectionIncluded');
    var sectionAchat   = document.getElementById('sectionPurchase');
    var separateur     = document.getElementById('catDivider');

    var jeuxInclus = [];
    var jeuxAchat  = [];
    var recherche  = '';

    // Prix disponibles pour les jeux à l'achat (attribués selon l'ID du jeu)
    var listeP = [9.99, 14.99, 19.99, 24.99, 29.99, 39.99, 49.99, 59.99];

    function formaterPrix(n) {
        return n.toFixed(2).replace('.', ',') + ' €';
    }

    function getPrix(id) {
        return listeP[id % listeP.length];
    }

    // Protège contre les injections XSS en échappant les caractères spéciaux
    function echapper(texte) {
        if (!texte) return '';
        texte = texte.replace(/&/g, '&amp;');
        texte = texte.replace(/</g, '&lt;');
        texte = texte.replace(/>/g, '&gt;');
        texte = texte.replace(/"/g, '&quot;');
        return texte;
    }



    // Affiche les cartes d'une section (inclus ou achat)
    function afficherSection(jeux, grille, estAchat) {
        grille.innerHTML = '';

        for (var i = 0; i < jeux.length; i++) {
            var j    = jeux[i];
            var tags = (j.genre || '').split(',');
            var premierTag = tags[0] ? tags[0].trim().toLowerCase() : '';

            var carte = document.createElement('a');
            carte.className = estAchat ? 'catalogue-card catalogue-card--purchase' : 'catalogue-card';
            carte.href = '/NEBULA/produit.php?id=' + j.id_jeu;
            carte.dataset.genre = premierTag;

            // Stocker tous les genres pour le filtrage
            var tagsNorm = [];
            for (var t = 0; t < tags.length; t++) {
                tagsNorm.push(tags[t].trim().toLowerCase());
            }
            carte.dataset.genres = tagsNorm.join('|');
            carte.dataset.title  = (j.titre || '').toLowerCase();

            // Image ou placeholder gris
            var htmlImage = j.image_url
                ? '<img src="' + echapper(j.image_url) + '" alt="' + echapper(j.titre) + '">'
                : '<div class="catalogue-card-placeholder"></div>';

            // Tags affichés sur la carte (2 max)
            var htmlTags = '';
            for (var t2 = 0; t2 < Math.min(tags.length, 2); t2++) {
                if (tags[t2].trim()) {
                    htmlTags += '<span>' + echapper(tags[t2].trim()) + '</span>';
                }
            }
            if (htmlTags) {
                htmlTags = '<div class="catalogue-card-tags">' + htmlTags + '</div>';
            }

            // Badge et bouton différents selon inclus ou achat
            var htmlBadge, htmlAction;
            if (estAchat) {
                var prix  = getPrix(j.id_jeu);
                htmlBadge  = '<div class="catalogue-price-badge">' + formaterPrix(prix) + '</div>';
                htmlAction = '<div class="catalogue-buy-btn">Acheter</div>';
            } else {
                htmlBadge  = '<div class="catalogue-included-badge">Inclus</div>';
                htmlAction = '<div class="catalogue-play-btn">Jouer</div>';
            }

            carte.innerHTML =
                '<div class="catalogue-card-poster">' + htmlImage + '</div>' +
                htmlBadge +
                '<div class="catalogue-card-overlay">' +
                    htmlTags +
                    '<div class="catalogue-card-title">' + echapper(j.titre) + '</div>' +
                    htmlAction +
                '</div>';

            grille.appendChild(carte);
        }
    }

    // Cache ou affiche les cartes selon le genre et la recherche actifs
    function appliquerFiltres() {
        var totalVisible = 0;
        var sections = [
            { grille: grilleInclus, section: sectionInclus },
            { grille: grilleAchat,  section: sectionAchat  }
        ];

        for (var s = 0; s < sections.length; s++) {
            var cartes  = sections[s].grille.querySelectorAll('.catalogue-card');
            var visible = 0;

            for (var c = 0; c < cartes.length; c++) {
                var carte   = cartes[c];
                var genres  = (carte.dataset.genres || '').split('|');
                var titre   = carte.dataset.title || '';
                var rechOk  = recherche === '' || titre.indexOf(recherche) !== -1;

                if (rechOk) {
                    carte.removeAttribute('hidden');
                    visible++;
                } else {
                    carte.setAttribute('hidden', '');
                }
            }

            if (sections[s].section) {
                sections[s].section.style.display = visible === 0 ? 'none' : '';
            }
            totalVisible += visible;
        }

        // Cacher le séparateur si une des deux sections est vide
        if (separateur) {
            var affInclus = sectionInclus ? sectionInclus.style.display : '';
            var affAchat  = sectionAchat  ? sectionAchat.style.display  : '';
            separateur.style.display = (affInclus === 'none' || affAchat === 'none') ? 'none' : '';
        }

        if (messageVide) {
            messageVide.style.display = totalVisible === 0 ? 'block' : 'none';
        }
    }

    // Charge les jeux depuis l'API puis les affiche
    function chargerJeux() {
        fetch(URL_API)
            .then(function(reponse) {
                if (!reponse.ok) {
                    throw new Error('Erreur serveur : ' + reponse.status);
                }
                return reponse.json();
            })
            .then(function(donnees) {
                if (!Array.isArray(donnees)) return;

                // Séparer les jeux : ID pair = achat, ID impair = inclus dans l'abonnement
                jeuxInclus = [];
                jeuxAchat  = [];
                for (var i = 0; i < donnees.length; i++) {
                    if (donnees[i].id_jeu % 2 !== 0) {
                        jeuxInclus.push(donnees[i]);
                    } else {
                        jeuxAchat.push(donnees[i]);
                    }
                }

                if (compteurInclus) compteurInclus.textContent = jeuxInclus.length;
                if (compteurAchat)  compteurAchat.textContent  = jeuxAchat.length;


                afficherSection(jeuxInclus, grilleInclus, false);
                afficherSection(jeuxAchat,  grilleAchat,  true);
                appliquerFiltres();
            })
            .catch(function() {
                if (grilleInclus) {
                    grilleInclus.innerHTML = '<p class="catalogue-api-error">Impossible de charger le catalogue. Réessayez plus tard.</p>';
                }
                if (grilleAchat) grilleAchat.innerHTML = '';
            });
    }

    // Déclencher le filtrage à chaque frappe dans la barre de recherche
    if (champRecherche) {
        champRecherche.addEventListener('input', function() {
            recherche = champRecherche.value.toLowerCase().trim();
            appliquerFiltres();
        });
    }

    chargerJeux();
});
