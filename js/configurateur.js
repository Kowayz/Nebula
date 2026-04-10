// configurateur.js — Calculateur de prix en temps réel

document.addEventListener('DOMContentLoaded', function() {

    var boutiqueCases  = document.querySelectorAll('.boutique-checkbox');
    var boutiqueCartes = document.querySelectorAll('.boutique-card');
    var qualiteRadios  = document.querySelectorAll('.quality-radio');
    var optionCases    = document.querySelectorAll('.option-checkbox');
    var optionCartes   = document.querySelectorAll('.option-card');

    var resumeBoutique       = document.getElementById('summaryBoutique');
    var resumeQualiteNom     = document.getElementById('summaryQualityName');
    var resumeQualitePrix    = document.getElementById('summaryQualityPrice');
    var resumeOptionsListe   = document.getElementById('summaryOptionsList');
    var resumeOptionsSection = document.getElementById('summaryOptionsSection');
    var resumeTotal          = document.getElementById('summaryTotal');
    var compteurBoutique     = document.getElementById('boutiqueCount');

    // Noms lisibles pour le résumé
    var nomsQualite = {
        'starter': 'Starter',
        'gamer':   'Gamer',
        'ultra':   'Ultra'
    };

    var nomsOptions = {
        'raytracing':  'Ray Tracing',
        'savecloud':   'Cloud illimité',
        'support':     'Support 24/7',
        'multidevice': 'Multi-appareils'
    };

    function formaterPrix(n) {
        return n.toFixed(2).replace('.', ',') + ' €';
    }

    // Met à jour le résumé et le total affiché
    function mettreAJour() {

        // Boutique : articles cochés
        var articlesCochesCases = [];
        for (var i = 0; i < boutiqueCases.length; i++) {
            if (boutiqueCases[i].checked) articlesCochesCases.push(boutiqueCases[i]);
        }

        var totalBoutique = 0;
        var nb = articlesCochesCases.length;

        if (compteurBoutique) {
            compteurBoutique.textContent = nb === 0 ? '0 article' : nb + ' article' + (nb > 1 ? 's' : '');
        }

        if (nb === 0) {
            resumeBoutique.innerHTML = '<span class="summary-empty">Aucun article</span>';
        } else {
            var htmlBoutique = '';
            for (var j = 0; j < articlesCochesCases.length; j++) {
                var prix = parseFloat(articlesCochesCases[j].dataset.price);
                totalBoutique += prix;
                htmlBoutique +=
                    '<div class="summary-line">' +
                        '<span class="summary-line-name">' + articlesCochesCases[j].dataset.label + '</span>' +
                        '<span class="summary-line-price">+' + formaterPrix(prix) + '</span>' +
                    '</div>';
            }
            resumeBoutique.innerHTML = htmlBoutique;
        }

        // Qualité : radio sélectionné
        var qualiteActive = null;
        for (var k = 0; k < qualiteRadios.length; k++) {
            if (qualiteRadios[k].checked) {
                qualiteActive = qualiteRadios[k];
                break;
            }
        }

        var prixQualite = qualiteActive ? parseFloat(qualiteActive.dataset.price) : 24.99;
        var idQualite   = qualiteActive ? qualiteActive.value : 'gamer';

        resumeQualiteNom.textContent  = nomsQualite[idQualite] ? nomsQualite[idQualite] : idQualite;
        resumeQualitePrix.textContent = formaterPrix(prixQualite);

        // Options cochées
        var optionsCochees = [];
        for (var l = 0; l < optionCases.length; l++) {
            if (optionCases[l].checked) optionsCochees.push(optionCases[l]);
        }

        var totalOptions = 0;

        if (optionsCochees.length === 0) {
            resumeOptionsSection.style.display = 'none';
            resumeOptionsListe.innerHTML = '';
        } else {
            resumeOptionsSection.style.display = '';
            var htmlOptions = '';
            for (var m = 0; m < optionsCochees.length; m++) {
                var prixOpt = parseFloat(optionsCochees[m].dataset.price);
                totalOptions += prixOpt;
                var nomOpt = nomsOptions[optionsCochees[m].value] ? nomsOptions[optionsCochees[m].value] : optionsCochees[m].value;
                htmlOptions +=
                    '<div class="summary-line">' +
                        '<span class="summary-line-name">' + nomOpt + '</span>' +
                        '<span class="summary-line-price">+' + formaterPrix(prixOpt) + '</span>' +
                    '</div>';
            }
            resumeOptionsListe.innerHTML = htmlOptions;
        }

        // Total final
        var total = prixQualite + totalOptions + totalBoutique;
        resumeTotal.textContent = formaterPrix(total);

        // Petite animation pour signaler le changement de prix
        resumeTotal.classList.remove('price-bump');
        resumeTotal.classList.add('price-bump');
    }

    // Cocher/décocher un article boutique met à jour la carte correspondante
    for (var i = 0; i < boutiqueCases.length; i++) {
        boutiqueCases[i].addEventListener('change', function() {
            for (var j = 0; j < boutiqueCases.length; j++) {
                boutiqueCartes[j].classList.toggle('selected', boutiqueCases[j].checked);
            }
            mettreAJour();
        });
    }

    // Changer la qualité
    for (var k = 0; k < qualiteRadios.length; k++) {
        qualiteRadios[k].addEventListener('change', mettreAJour);
    }

    // Cocher/décocher une option
    for (var l = 0; l < optionCases.length; l++) {
        optionCases[l].addEventListener('change', function() {
            for (var m = 0; m < optionCases.length; m++) {
                optionCartes[m].classList.toggle('selected', optionCases[m].checked);
            }
            mettreAJour();
        });
    }

    // Bouton "Commander" : construit l'URL panier avec les choix et redirige
    var btnCommander = document.getElementById('cmdCommander');
    if (btnCommander) {
        btnCommander.addEventListener('click', function() {
            var qualiteActive = null;
            for (var i = 0; i < qualiteRadios.length; i++) {
                if (qualiteRadios[i].checked) {
                    qualiteActive = qualiteRadios[i];
                    break;
                }
            }

            var idFallback = parseInt(btnCommander.dataset.fallbackOffre, 10) || 0;
            var idOffre    = qualiteActive ? parseInt(qualiteActive.dataset.dbId, 10) : 0;
            if (!idOffre) idOffre = idFallback;
            if (!idOffre) return;

            var url = '/NEBULA/panier.php?offre=' + idOffre;

            for (var j = 0; j < boutiqueCases.length; j++) {
                if (boutiqueCases[j].checked && boutiqueCases[j].dataset.dbId) {
                    url += '&produits[]=' + boutiqueCases[j].dataset.dbId;
                }
            }

            window.location.href = url;
        });
    }

    // Affichage initial au chargement de la page
    mettreAJour();
});
