<?php
require 'includes/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$pageTitle = 'Boutique';
$pageCSS   = ['boutique'];
$pageJS    = [];

try {
    $pdo    = getPDO();
    $offres = $pdo->query('SELECT * FROM offre ORDER BY prix_mensuel ASC')->fetchAll();
} catch (Exception $e) {
    $offres = [];
}

if (empty($offres)) {
    $offres = [
        ['id_offre'=>1,'nom_offre'=>'Starter','prix_mensuel'=>0.00, 'description'=>'Parfait pour découvrir'],
        ['id_offre'=>2,'nom_offre'=>'Gamer',  'prix_mensuel'=>24.99,'description'=>'Pour les joueurs réguliers'],
        ['id_offre'=>3,'nom_offre'=>'Ultra',  'prix_mensuel'=>44.99,'description'=>"L'expérience ultime"],
    ];
}

$planDetails = [
    'Starter' => [
        'category' => 'Abonnement',
        'gradient' => 'linear-gradient(135deg, #1e0838 0%, #0e0320 100%)',
        'icon'     => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(196,181,253,.7)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>',
        'badge'    => null,
        'hot'      => false,
        'perks'    => ['10h de jeu par mois', 'Qualité HD 720p', '+25 jeux inclus', 'Sauvegarde de base'],
    ],
    'Gamer' => [
        'category' => 'Abonnement populaire',
        'gradient' => 'linear-gradient(135deg, #2e1065 0%, #4c1d95 50%, #1e0838 100%)',
        'icon'     => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(196,181,253,.9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><path d="M9 8h6M12 6v4"/></svg>',
        'badge'    => 'Populaire',
        'hot'      => true,
        'perks'    => ['Jeu illimité', '4K Ultra HD + 144 FPS', '+200 jeux inclus', 'Ray tracing', 'Sauvegardes illimitées'],
    ],
    'Ultra' => [
        'category' => 'Abonnement premium',
        'gradient' => 'linear-gradient(135deg, #4c0519 0%, #9f1239 50%, #1e0838 100%)',
        'icon'     => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(244,114,182,.9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        'badge'    => 'Premium',
        'hot'      => false,
        'perks'    => ['Tout Gamer +', 'Support prioritaire 24/7', 'Accès anticipé', '2 appareils simultanés', 'Cadeaux exclusifs'],
    ],
];

require 'includes/header.php';
?>

<div class="boutique-page">

<!-- ══════════════════════════ HERO ══════════════════════════ -->
<div class="boutique-hero">
  <div class="boutique-hero-orb boutique-hero-orb-a"></div>
  <div class="boutique-hero-orb boutique-hero-orb-b"></div>
  <div class="boutique-hero-inner">
    <div class="boutique-hero-tag">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Boutique
    </div>
    <h1 class="boutique-hero-title">Choisissez votre <span class="gradient-text">abonnement</span></h1>
    <p class="boutique-hero-sub">Abonnements flexibles, sans engagement. Commencez gratuitement, évoluez à votre rythme.</p>
  </div>
</div>

<!-- ══════════════════════════ PLANS GRID ══════════════════════════ -->
<div class="boutique-section">
  <div class="boutique-section-header">
    <div class="boutique-section-title">Nos abonnements</div>
    <div class="boutique-section-sub">Choisissez la formule adaptée à votre façon de jouer</div>
  </div>

  <div class="merch-grid">
    <?php foreach ($offres as $o):
      $nom  = $o['nom_offre'];
      $prix = (float)$o['prix_mensuel'];
      $det  = $planDetails[$nom] ?? $planDetails['Starter'];
    ?>
    <div class="merch-card <?= $det['hot'] ? 'merch-card-hot' : '' ?>">
      <?php if ($det['badge']): ?>
        <div class="merch-hot-badge">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          <?= htmlspecialchars($det['badge']) ?>
        </div>
      <?php endif; ?>

      <div class="merch-img" style="background:<?= $det['gradient'] ?>; display:flex; align-items:center; justify-content:center;">
        <?= $det['icon'] ?>
      </div>

      <div class="merch-body">
        <div class="merch-category"><?= htmlspecialchars($det['category']) ?></div>
        <div class="merch-name"><?= htmlspecialchars($nom) ?></div>
        <div class="merch-desc"><?= implode(' · ', array_slice($det['perks'], 0, 2)) ?></div>
        <div class="merch-footer">
          <div class="merch-price">
            <?= $prix === 0.0 ? 'Gratuit' : number_format($prix, 2, ',', '') . ' €/mois' ?>
          </div>
          <?php if ($prix === 0.0): ?>
            <a href="/NEBULA/auth.php?tab=register" class="btn btn-outline btn-sm">Commencer</a>
          <?php else: ?>
            <a href="/NEBULA/panier.php?offre=<?= (int)$o['id_offre'] ?>" class="btn <?= $det['hot'] ? 'btn-primary' : 'btn-outline' ?> btn-sm">Ajouter</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- ══════════════════════════ GUARANTEES ══════════════════════════ -->
<div class="boutique-guarantees">
  <div class="boutique-guarantee">
    <span class="boutique-guarantee-icon">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
    </span>
    <span>Paiement sécurisé SSL</span>
  </div>
  <div class="boutique-guarantee">
    <span class="boutique-guarantee-icon">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>
    </span>
    <span>Remboursement 7 jours</span>
  </div>
  <div class="boutique-guarantee">
    <span class="boutique-guarantee-icon">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    </span>
    <span>Sans engagement</span>
  </div>
  <div class="boutique-guarantee">
    <span class="boutique-guarantee-icon">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
    </span>
    <span>CB, PayPal, virement</span>
  </div>
</div>

<!-- ══════════════════════════ GIFT CARDS ══════════════════════════ -->
<div class="boutique-section">
  <div class="boutique-section-header">
    <div class="boutique-section-title">Cartes cadeaux</div>
    <div class="boutique-section-sub">La carte cadeau parfaite pour les joueurs de votre entourage. Valable 12 mois.</div>
  </div>

  <div class="gift-grid">
    <!-- 10€ -->
    <div class="gift-card">
      <div class="gift-card-top">
        <div class="gift-card-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
        </div>
        <div class="gift-card-validity">12 mois</div>
      </div>
      <div class="gift-card-amount">10 €</div>
      <div class="gift-card-name">Carte Découverte</div>
      <div class="gift-card-desc">Idéale pour offrir un premier mois sur l'offre Starter ou compléter un abonnement existant.</div>
      <a href="/NEBULA/auth.php?tab=register" class="btn btn-outline btn-sm">Acheter</a>
    </div>

    <!-- 25€ featured -->
    <div class="gift-card gift-card-featured">
      <div class="gift-card-glow"></div>
      <div class="gift-card-top" style="position:relative;z-index:1">
        <div class="gift-card-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
        </div>
        <div class="gift-card-validity">Le plus offert</div>
      </div>
      <div class="gift-card-amount gradient-text">25 €</div>
      <div class="gift-card-name">Carte Gamer</div>
      <div class="gift-card-desc">Un mois d'abonnement Gamer offert, avec accès à tous les jeux et streaming 4K 144 FPS.</div>
      <a href="/NEBULA/auth.php?tab=register" class="btn btn-primary btn-sm">Acheter</a>
    </div>

    <!-- 50€ -->
    <div class="gift-card">
      <div class="gift-card-top">
        <div class="gift-card-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div class="gift-card-validity">12 mois</div>
      </div>
      <div class="gift-card-amount">50 €</div>
      <div class="gift-card-name">Carte Ultra</div>
      <div class="gift-card-desc">Un mois Ultra complet ou deux mois Gamer. L'abonnement premium pour les passionnés.</div>
      <a href="/NEBULA/auth.php?tab=register" class="btn btn-outline btn-sm">Acheter</a>
    </div>
  </div>

  <p class="text-center text-muted" style="margin-top:24px;font-size:.82rem">
    Cartes cadeaux livrées par e-mail en quelques minutes. Non remboursables mais cumulables.
  </p>
</div>

<!-- ══════════════════════════ SUB CTA ══════════════════════════ -->
<div class="boutique-sub-cta">
  <div class="boutique-sub-cta-inner">
    <div class="boutique-sub-cta-eyebrow">Configurateur</div>
    <h2 class="boutique-sub-cta-title">Composez votre bouquet sur mesure</h2>
    <p class="boutique-sub-cta-sub">Choisissez uniquement les genres et options qui vous intéressent. Payez exactement pour ce que vous utilisez.</p>
    <a href="/NEBULA/configurateur.php" class="btn btn-primary btn-lg">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
      Configurer mon bouquet
    </a>
  </div>
</div>

</div><!-- /.boutique-page -->

<?php require 'includes/footer.php'; ?>
