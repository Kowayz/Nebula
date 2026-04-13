<?php
/* ============================================================
   BOUTIQUE.PHP — Page boutique / merchandising
   Affiche les produits dérivés Nebula (t-shirts, mugs, etc.),
   les garanties de paiement et un CTA vers le configurateur.
   Chaque produit propose un lien "Ajouter" vers panier.php.
   ============================================================ */

// -- Configuration de la page (titre, CSS, JS) --
$pageTitle = 'Boutique';
$pageCSS   = ['boutique'];
$pageJS    = [];

// -- Charger les produits depuis la BDD --
require 'includes/db.php';
$pdo = getPDO();
$produits = $pdo->query('
    SELECT p.id_produit, p.nom_produit, p.description, p.prix_unitaire, p.image_url, c.libelle AS categorie
    FROM produit p
    JOIN categorie c ON c.id_cat = p.id_cat
    ORDER BY c.id_cat, p.id_produit
')->fetchAll();

// -- Inclure le header commun --
require 'includes/header.php';
?>

<div class="boutique-page">

<!-- ══════════════════════════ HERO ══════════════════════════
     Bannière avec orbes décoratives et titre "Nebula Merch"
     ══════════════════════════════════════════════════════════ -->
<div class="boutique-hero">
  <div class="boutique-hero-orb boutique-hero-orb-a"></div>
  <div class="boutique-hero-orb boutique-hero-orb-b"></div>
  <div class="boutique-hero-inner">
    <div class="boutique-hero-tag">
      <img src="/NEBULA/public/assets/img/icons/ecommerce/panier.png" alt="icon" width="18" height="18" class="icon-img">
      Boutique
    </div>
    <h1 class="boutique-hero-title">Nebula <span class="gradient-text">Merch</span></h1>
    <p class="boutique-hero-sub">T-shirts, mugs et accessoires pour les vrais fans de gaming.</p>
  </div>
</div>

<!-- ══════════════════════════ GRILLE PRODUITS ═════════════════
     6 cartes produits (merch-card) avec image, nom, description,
     prix et bouton d'ajout au panier via panier.php?add=
     ══════════════════════════════════════════════════════════ -->
<div class="boutique-section">
  <div class="boutique-section-header">
    <div class="boutique-section-title">Produits</div>
    <div class="boutique-section-sub">Collection exclusive Nebula</div>
  </div>

  <div class="merch-grid">
    <?php foreach ($produits as $p): ?>
    <div class="merch-card">
      <div class="merch-img">
        <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['nom_produit']) ?>">
      </div>
      <div class="merch-body">
        <div class="merch-category"><?= htmlspecialchars($p['categorie']) ?></div>
        <div class="merch-name"><?= htmlspecialchars($p['nom_produit']) ?></div>
        <div class="merch-desc"><?= htmlspecialchars($p['description']) ?></div>
        <div class="merch-footer">
          <div class="merch-price"><?= number_format($p['prix_unitaire'], 2, ',', ' ') ?> €</div>
          <a href="/NEBULA/panier.php?add=<?= $p['id_produit'] ?>&cat=boutique&nom=<?= urlencode($p['nom_produit']) ?>&prix=<?= $p['prix_unitaire'] ?>" class="btn btn-outline btn-sm">Ajouter</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- ══════════════════════════ GARANTIES ══════════════════════
     Bandeau de 4 garanties (paiement, remboursement, etc.)
     ══════════════════════════════════════════════════════════ -->
<div class="boutique-guarantees">
  <div class="boutique-guarantee">
    <span class="boutique-guarantee-icon">
      <img src="/NEBULA/public/assets/img/icons/dashboard/bouclier-securite.png" alt="icon" width="20" height="20" class="icon-img">
    </span>
    <span>Paiement sécurisé SSL</span>
  </div>
  <div class="boutique-guarantee">
    <span class="boutique-guarantee-icon">
      <img src="/NEBULA/public/assets/img/icons/dashboard/horloge.png" alt="icon" width="20" height="20" class="icon-img">
    </span>
    <span>Remboursement 7 jours</span>
  </div>
  <div class="boutique-guarantee">
    <span class="boutique-guarantee-icon">
      <img src="/NEBULA/public/assets/img/icons/ecommerce/calendrier.png" alt="icon" width="20" height="20" class="icon-img">
    </span>
    <span>Sans engagement</span>
  </div>
  <div class="boutique-guarantee">
    <span class="boutique-guarantee-icon">
      <img src="/NEBULA/public/assets/img/icons/ecommerce/card.png" alt="icon" width="20" height="20" class="icon-img">
    </span>
    <span>CB, PayPal, virement</span>
  </div>
</div>

<!-- ══════════════════════════ CTA CONFIGURATEUR ═══════════════
     Bandeau d'appel à l'action vers le configurateur de bouquet
     ══════════════════════════════════════════════════════════ -->
<div class="boutique-sub-cta">
  <h2 class="boutique-sub-cta-title">Composez votre bouquet sur mesure</h2>
  <p class="boutique-sub-cta-sub">Choisissez uniquement les genres et options qui vous intéressent. Payez exactement pour ce que vous utilisez.</p>
  <a href="/NEBULA/configurateur.php" class="btn btn-primary btn-lg">Configurer mon bouquet</a>
</div>

</div><!-- /.boutique-page -->

<?php require 'includes/footer.php'; ?>
