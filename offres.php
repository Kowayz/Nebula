<?php
require 'includes/db.php';

$pageTitle = 'Tarifs';
$pageCSS   = ['offres'];
$pageJS    = ['offres'];

try {
    $pdo    = getPDO();
    $stmt   = $pdo->query('SELECT * FROM offre ORDER BY prix_mensuel ASC');
    $offres = $stmt->fetchAll();
} catch (Exception $e) {
    $offres = [];
}

if (empty($offres)) {
    $offres = [
        ['id_offre'=>1,'nom_offre'=>'Starter','prix_mensuel'=>0.00,  'description'=>'Parfait pour découvrir le cloud gaming'],
        ['id_offre'=>2,'nom_offre'=>'Gamer',  'prix_mensuel'=>24.99, 'description'=>'Pour les joueurs réguliers'],
        ['id_offre'=>3,'nom_offre'=>'Ultra',  'prix_mensuel'=>44.99, 'description'=>"L'expérience gaming ultime"],
    ];
}

$features = [
    'Starter' => [
        [true,  '10h de jeu par mois'],
        [true,  'Qualité HD (720p)'],
        [true,  'Accès à +25 jeux'],
        [true,  'Latence standard'],
        [false, 'Ray tracing'],
        [false, 'Accès prioritaire'],
        [false, 'Support 24/7'],
    ],
    'Gamer' => [
        [true,  'Jouez en illimité'],
        [true,  'Qualité 4K Ultra HD'],
        [true,  'Accès à +200 jeux'],
        [true,  'Latence ultra-faible'],
        [true,  'Ray tracing'],
        [true,  'Sauvegardes illimitées'],
        [false, 'Support prioritaire'],
    ],
    'Ultra' => [
        [true, 'Tout de Gamer +'],
        [true, 'Sessions prioritaires'],
        [true, 'Support 24/7'],
        [true, 'Accès anticipé aux nouveautés'],
        [true, 'Streaming simultané (2 appareils)'],
        [true, 'Cadeaux exclusifs'],
        [true, 'Support prioritaire'],
    ],
];

$featuredIndex = 1;

$svgCheck = '<img src="/NEBULA/public/assets/img/icons/ecommerce/coche-incluse.png" alt="icon" width="14" height="14" class="icon-img">';
$svgCross = '<img src="/NEBULA/public/assets/img/icons/nav/croix-fermer.png" alt="icon" width="14" height="14" class="icon-img">';

require 'includes/header.php';
?>

<!-- ══════════════════════════ HEADER ══════════════════════════ -->
<section class="section text-center" style="padding-bottom:40px">
  <div class="section-tag">Tarifs</div>
  <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;margin-bottom:12px;letter-spacing:-.03em">
    Choisissez votre <span class="gradient-text">offre</span>
  </h1>
  <p class="text-muted">Commencez gratuitement, évoluez quand vous le souhaitez. Sans engagement.</p>
</section>

<!-- ══════════════════════════ PRICING CARDS ══════════════════════════ -->
<section class="section" style="padding-top:0">
  <div class="pricing-grid">
    <?php foreach ($offres as $i => $o):
      $nom    = $o['nom_offre'];
      $prix   = (float)$o['prix_mensuel'];
      $desc   = $o['description'];
      $fts    = $features[$nom] ?? [];
      $isFeat = ($i === $featuredIndex);
    ?>
    <div class="pricing-card <?= $isFeat ? 'featured' : '' ?>">
      <?php if ($isFeat): ?>
        <div class="pricing-badge">
          <img src="/NEBULA/public/assets/img/icons/platforms/etoile-pleine.png" alt="icon" width="14" height="14" class="icon-img">
          Plus populaire
        </div>
      <?php endif; ?>

      <div class="pricing-name"><?= htmlspecialchars($nom) ?></div>
      <div class="pricing-sub"><?= htmlspecialchars($desc) ?></div>

      <div class="pricing-price">
        <span class="price-amount"><?= $prix === 0.0 ? 'Gratuit' : number_format($prix, 2, '.', '') ?></span>
        <?php if ($prix > 0): ?><span class="price-period"> €/mois</span><?php endif; ?>
      </div>

      <?php if (!empty($fts)): ?>
      <ul class="pricing-features">
        <?php foreach ($fts as [$flag, $label]): ?>
          <li class="pricing-feature <?= $flag ? 'yes' : '' ?>">
            <?php if ($flag): ?>
              <img src="/NEBULA/public/assets/img/icons/ecommerce/coche-incluse.png" alt="icon" width="14" height="14" class="icon-img">
            <?php else: ?>
              <img src="/NEBULA/public/assets/img/icons/nav/croix-fermer.png" alt="icon" width="14" height="14" class="icon-img">
            <?php endif; ?>
            <?= htmlspecialchars($label) ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>

      <a href="/NEBULA/auth.php?tab=register" class="btn <?= $isFeat ? 'btn-primary' : 'btn-outline' ?> btn-full">
        <?= $prix === 0.0 ? 'Commencer gratuitement' : "S'abonner" ?>
      </a>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ══════════════════════════ GAMES PREVIEW ══════════════════════════ -->
<section class="section offres-games-section" style="padding-top:0;padding-bottom:64px">
  <div class="offres-games-head">
    <div>
      <h2 class="offres-games-title">Ce qui est inclus dans votre abonnement</h2>
      <p class="offres-games-sub">Des centaines de jeux AAA disponibles instantanément, sans téléchargement.</p>
    </div>
    <a href="/NEBULA/jeux.php" class="btn btn-outline btn-sm offres-games-link">Voir tout le catalogue →</a>
  </div>
  <div class="offres-games-grid" id="offresGamesGrid">
    <div class="offres-game-skeleton"></div>
    <div class="offres-game-skeleton"></div>
    <div class="offres-game-skeleton"></div>
    <div class="offres-game-skeleton"></div>
    <div class="offres-game-skeleton"></div>
    <div class="offres-game-skeleton"></div>
  </div>
</section>

<!-- ══════════════════════════ COMPARISON TABLE ══════════════════════════ -->
<section class="section" style="padding-top:0">
  <h2 class="text-center" style="font-size:1.35rem;font-weight:800;margin-bottom:28px;letter-spacing:-.02em">
    Tableau comparatif détaillé
  </h2>
  <div class="compare-wrap">
    <table class="compare-table">
      <thead>
        <tr>
          <th>Fonctionnalité</th>
          <?php foreach ($offres as $i => $o): ?>
            <th <?= $i === $featuredIndex ? 'class="col-featured"' : '' ?>>
              <?= htmlspecialchars($o['nom_offre']) ?>
            </th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $rows = [
          'Résolution 4K Ultra HD'           => [false, true,  true ],
          'Grande bibliothèque (+200 jeux)'  => [false, true,  true ],
          'Ray Tracing'                      => [false, true,  true ],
          'Latence ultra-faible'             => [false, true,  true ],
          'Sessions prioritaires'            => [false, false, true ],
          'Streaming multi-appareils'        => [false, false, true ],
          'Accès anticipé aux nouveaux jeux' => [false, false, true ],
        ];
        foreach ($rows as $label => $cols): ?>
        <tr>
          <td><?= htmlspecialchars($label) ?></td>
          <?php foreach ($cols as $v): ?>
            <td>
              <?php if ($v): ?>
                <img src="/NEBULA/public/assets/img/icons/ecommerce/coche-incluse.png" alt="icon" width="14" height="14" class="icon-img">
              <?php else: ?>
                <img src="/NEBULA/public/assets/img/icons/nav/croix-fermer.png" alt="icon" width="14" height="14" class="icon-img">
              <?php endif; ?>
            </td>
          <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Bouquet CTA inside compare-wrap -->
    <div class="bouquet-cta">
      <h2 class="bouquet-cta-title">Créez votre bouquet sur mesure</h2>
      <p class="bouquet-cta-sub">Pourquoi s'adapter à une liste prédéfinie quand vous pouvez composer la vôtre ?</p>
      <a href="/NEBULA/configurateur.php" class="btn btn-primary btn-lg">Configurer mon bouquet</a>
    </div>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
