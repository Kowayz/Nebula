// configurateur.js — Configurateur de bouquet Nebula

// ── Accumulateurs de prix pour chaque section du formulaire ──
var prixBoutique = 0;   // somme des accessoires sélectionnés
var prixOffre    = 0;   // prix du plan d'abonnement choisi (0 / 24.99 / 44.99)
var prixOptions  = 0;   // somme des options supplémentaires sélectionnées
var nomOffre     = '';  // label du plan affiché dans le résumé (ex: "Gamer")

// ══════════════════════════════════════════════════════════════
// RÉSUMÉ — recalcule et réécrit la sidebar à chaque interaction
// ══════════════════════════════════════════════════════════════
function majResume() {
  // Additionne les 3 postes pour obtenir le total mensuel
  var total = prixBoutique + prixOffre + prixOptions;

  // Écrit le total dans #summaryTotal (format: "24,99 €")
  document.getElementById('summaryTotal').textContent = total.toFixed(2).replace('.', ',') + ' €';

  // Met à jour le nom du plan choisi ("-" si aucun)
  document.getElementById('summaryPlanName').textContent = nomOffre || '-';
  // Met à jour le prix du plan ("-" si gratuit/non choisi)
  document.getElementById('summaryPlanPrice').textContent = prixOffre > 0 ? prixOffre.toFixed(2).replace('.', ',') + ' €' : '-';

  // -- Liste des accessoires --
  var elBoutique     = document.getElementById('summaryBoutique');
  var cartesProduits = document.querySelectorAll('.merch-card.selected'); // toutes les cartes actives
  if (cartesProduits.length === 0) {
    elBoutique.innerHTML = '<span class="summary-empty">Aucun article</span>';
  } else {
    var html = '';
    for (var i = 0; i < cartesProduits.length; i++) {
      var nom  = cartesProduits[i].querySelector('button').dataset.nom;           // data-nom du bouton
      var prix = parseFloat(cartesProduits[i].querySelector('button').dataset.prix); // data-prix du bouton
      // Construit une ligne "Nom — +X,XX €"
      html += '<div class="summary-line">';
      html += '<span class="summary-line-name">' + nom + '</span>';
      html += '<span class="summary-line-price">+' + prix.toFixed(2).replace('.', ',') + ' €</span>';
      html += '</div>';
    }
    elBoutique.innerHTML = html;
  }

  // -- Liste des options --
  var elOptions     = document.getElementById('summaryOptionsList');
  var cartesOptions = document.querySelectorAll('.option-card.selected'); // toutes les options actives
  if (cartesOptions.length === 0) {
    elOptions.innerHTML = '<span class="summary-empty">Aucune option</span>';
  } else {
    var htmlOpt = '';
    for (var j = 0; j < cartesOptions.length; j++) {
      var nomOpt  = cartesOptions[j].querySelector('.option-name').textContent;           // texte du titre
      var prixOpt = parseFloat(cartesOptions[j].querySelector('button').dataset.price);  // data-price du bouton
      // Construit une ligne "Nom — +X,XX €"
      htmlOpt += '<div class="summary-line">';
      htmlOpt += '<span class="summary-line-name">' + nomOpt + '</span>';
      htmlOpt += '<span class="summary-line-price">+' + prixOpt.toFixed(2).replace('.', ',') + ' €</span>';
      htmlOpt += '</div>';
    }
    elOptions.innerHTML = htmlOpt;
  }
}


// ══════════════════════════════════════════════════════════════
// ÉTAPE 1 : ACCESSOIRES (sélection multiple — toggle)
// ══════════════════════════════════════════════════════════════

var btnsProduits = document.querySelectorAll('.merch-card button'); // tous les boutons "Ajouter"

for (var p = 0; p < btnsProduits.length; p++) {
  btnsProduits[p].addEventListener('click', function() {
    var btn  = this;                              // bouton cliqué
    var card = btn.closest('.merch-card');         // carte parente du bouton
    var prix = parseFloat(btn.dataset.prix);      // prix lu depuis data-prix

    if (card.classList.contains('selected')) {
      // Déjà sélectionné → on retire la sélection
      card.classList.remove('selected');
      btn.textContent = 'Ajouter';
      btn.classList.remove('btn-primary');
      btn.classList.add('btn-outline');
      prixBoutique -= prix; // on soustrait du cumul
    } else {
      // Pas encore sélectionné → on l'ajoute
      card.classList.add('selected');
      btn.textContent = 'Ajouté';
      btn.classList.remove('btn-outline');
      btn.classList.add('btn-primary');
      prixBoutique += prix; // on ajoute au cumul
    }

    majResume(); // rafraîchit la sidebar
  });
}


// ══════════════════════════════════════════════════════════════
// ÉTAPE 2 : OFFRE (sélection unique — style radio)
// ══════════════════════════════════════════════════════════════

var btnsOffres  = document.querySelectorAll('.pricing-card button'); // boutons Sélectionner
var cardsOffres = document.querySelectorAll('.pricing-card');        // cartes Starter/Gamer/Ultra

for (var i = 0; i < btnsOffres.length; i++) {
  btnsOffres[i].addEventListener('click', function() {
    var btn = this;

    // 1. Réinitialise toutes les cartes (désélection globale)
    for (var j = 0; j < cardsOffres.length; j++) {
      cardsOffres[j].classList.remove('selected');
      btnsOffres[j].textContent = 'Sélectionner';
      btnsOffres[j].classList.remove('btn-primary');
      btnsOffres[j].classList.add('btn-outline');
    }

    // 2. Sélectionne uniquement la carte cliquée
    btn.textContent = 'Sélectionné';
    btn.classList.remove('btn-outline');
    btn.classList.add('btn-primary');
    btn.closest('.pricing-card').classList.add('selected');

    // 3. Mémorise le prix (data-price) et le label (data-plan) du plan choisi
    prixOffre = parseFloat(btn.dataset.price);
    var plans = { starter: 'Starter', gamer: 'Gamer', ultra: 'Ultra' };
    nomOffre  = plans[btn.dataset.plan]; // convertit la clé en label lisible

    majResume(); // rafraîchit la sidebar
  });
}

// Sélectionne Gamer par défaut au chargement (index 1 = 2e carte)
if (btnsOffres.length > 1) {
  btnsOffres[1].click();
}


// ══════════════════════════════════════════════════════════════
// ÉTAPE 3 : OPTIONS (sélection multiple — même logique qu'étape 1)
// ══════════════════════════════════════════════════════════════

var btnsOptions = document.querySelectorAll('.option-card button'); // boutons "Ajouter" des options

for (var k = 0; k < btnsOptions.length; k++) {
  btnsOptions[k].addEventListener('click', function() {
    var btn  = this;
    var card = btn.closest('.option-card'); // carte parente
    var prix = parseFloat(btn.dataset.price); // prix lu depuis data-price

    if (card.classList.contains('selected')) {
      // Déjà sélectionné → retire
      card.classList.remove('selected');
      btn.textContent = 'Ajouter';
      btn.classList.remove('btn-primary');
      btn.classList.add('btn-outline');
      prixOptions -= prix;
    } else {
      // Pas encore sélectionné → ajoute
      card.classList.add('selected');
      btn.textContent = 'Ajouté';
      btn.classList.remove('btn-outline');
      btn.classList.add('btn-primary');
      prixOptions += prix;
    }

    majResume(); // rafraîchit la sidebar
  });
}


// ══════════════════════════════════════════════════════════════
// BOUTON COMMANDER → redirige vers le panier avec le total
// ══════════════════════════════════════════════════════════════

var btnCommander = document.getElementById('summaryOrderBtn');
if (btnCommander) {
  btnCommander.addEventListener('click', function(e) {
    e.preventDefault(); // bloque la navigation par défaut du <a>
    var total = prixBoutique + prixOffre + prixOptions;
    // Redirige vers panier.php en passant le total calculé en paramètre GET
    window.location.href = '/NEBULA/panier.php?add=999&cat=boutique&nom=Bouquet+Nebula&prix=' + total.toFixed(2);
  });
}

// Initialise le résumé au chargement (après le clic Gamer par défaut ci-dessus)
majResume();
