<?php
require 'includes/db.php';

$pageTitle = 'Jouez à vos jeux n\'importe où';
$pageCSS   = ['index'];
$pageJS    = [];

try {
    $pdo  = getPDO();
    $stmt = $pdo->query('SELECT * FROM jeu ORDER BY id_jeu LIMIT 6');
    $jeux = $stmt->fetchAll();
} catch (Exception $e) {
    $jeux = [];
}

require 'includes/header.php';
?>

<!-- ═══════════════════════════════ HERO ═══════════════════ -->
<section class="hero">
  <h1>Jouez à vos jeux<br><span class="gradient-text">n'importe où</span></h1>
  <p>Profitez de vos jeux préférés en streaming haute qualité sans téléchargement, sur tous vos appareils</p>

  <div class="hero-actions">
    <a href="/NEBULA/auth.php?tab=register" class="btn btn-primary btn-lg">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
      Commencer gratuitement
    </a>
    <a href="/NEBULA/demo.php" class="btn btn-outline btn-lg">Voir la démo</a>
  </div>

  <div class="hero-stats">
    <div class="hero-stat">
      <span class="stat-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
      </span>
      <div><span class="stat-value">4K Ultra HD</span><span class="stat-label">Résolution maximale</span></div>
    </div>
    <div class="hero-stat">
      <span class="stat-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
      </span>
      <div><span class="stat-value">144 FPS</span><span class="stat-label">Fluidité maximale</span></div>
    </div>
    <div class="hero-stat">
      <span class="stat-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </span>
      <div><span class="stat-value">&lt; 20ms</span><span class="stat-label">Latence ultra-faible</span></div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════ BIBLIOTHÈQUE ════════════════ -->
<section class="section library-section" style="background:var(--bg-surface);border-top:1px solid var(--border)">
  <div class="section-header">
    <div class="section-tag">Bibliothèque</div>
    <h2>Une bibliothèque infinie</h2>
    <p>Des centaines de jeux AAA disponibles instantanément, de nouvelles sorties chaque mois</p>
  </div>

  <div class="games-grid">
    <?php
    $display = !empty($jeux) ? $jeux : [
      ['id_jeu'=>1,'titre'=>'ARC Raiders',    'genre'=>'Extraction Shooter','image_url'=>'','description'=>'Affrontez des machines implacables venues des cieux dans ce shooter PvPvE intense.'],
      ['id_jeu'=>2,'titre'=>'Cyberpunk 2077',  'genre'=>'Action-RPG',        'image_url'=>'','description'=>'Incarnez V dans la mégalopole de Night City, un monde cyberpunk sombre et immersif.'],
      ['id_jeu'=>3,'titre'=>'Elden Ring',       'genre'=>'Action-RPG',        'image_url'=>'','description'=>'Explorez les Terres Intermédiaires dans cet action-RPG épique co-écrit par Miyazaki.'],
      ['id_jeu'=>4,'titre'=>"No Man's Sky",     'genre'=>'Exploration',       'image_url'=>'','description'=>'Voyagez de planète en planète dans un univers procédural infini.'],
      ['id_jeu'=>5,'titre'=>'Hades II',         'genre'=>'Roguelike',         'image_url'=>'','description'=>'Incarnez Mélinoé dans ce dungeon crawler inspiré de la mythologie grecque.'],
      ['id_jeu'=>6,'titre'=>'Forza Horizon 5',  'genre'=>'Course',            'image_url'=>'','description'=>'500 voitures iconiques, le Mexique en monde ouvert.'],
    ];

    $genreColors = [
      'Action-RPG'          => ['rgba(124,58,237,.6)','rgba(159,18,57,.4)'],
      'Extraction Shooter'  => ['rgba(6,182,212,.5)', 'rgba(124,58,237,.4)'],
      'Exploration'         => ['rgba(34,197,94,.4)', 'rgba(124,58,237,.3)'],
      'Roguelike'           => ['rgba(245,158,11,.5)','rgba(159,18,57,.4)'],
      'Course'              => ['rgba(239,68,68,.5)', 'rgba(245,158,11,.3)'],
    ];

    foreach ($display as $j):
      $genre = trim(explode(',', $j['genre'])[0]);
      $cols  = $genreColors[$genre] ?? ['rgba(124,58,237,.5)','rgba(159,18,57,.35)'];
    ?>
    <div class="game-card">
      <!-- Image ou placeholder gradient -->
      <?php if (!empty($j['image_url'])): ?>
        <div class="game-card-img">
          <img src="/NEBULA/<?= htmlspecialchars($j['image_url']) ?>"
               alt="<?= htmlspecialchars($j['titre']) ?>" loading="lazy">
        </div>
      <?php else: ?>
        <div class="game-card-placeholder" style="background:linear-gradient(135deg,<?= $cols[0] ?>,<?= $cols[1] ?>,#060210)">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.15)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><path d="M9 8h6M12 6v4"/></svg>
        </div>
      <?php endif; ?>

      <!-- Badge genre -->
      <div class="game-card-badge"><?= htmlspecialchars($genre) ?></div>

      <!-- Overlay avec infos -->
      <div class="game-card-overlay">
        <div class="game-card-meta">
          <div class="game-card-title"><?= htmlspecialchars($j['titre']) ?></div>
          <div class="game-card-bottom">
            <div class="game-card-platforms">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><circle cx="12" cy="12" r="9.5"/><path d="M8.5 8.5 15.5 15.5M15.5 8.5 8.5 15.5"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21V3h5a3.5 3.5 0 010 7H8"/><path d="M5 21h14"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            </div>
            <a href="/NEBULA/auth.php?tab=register" class="game-card-cta">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
              Jouer
            </a>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="text-center mt-32">
    <a href="/NEBULA/jeux.php" class="btn btn-outline">Voir tous les jeux</a>
  </div>
</section>

<!-- ═══════════════════════════ FONCTIONNALITÉS ═════════════ -->
<section class="section features-section">
  <div class="section-header">
    <div class="section-tag">Pourquoi Nebula</div>
    <h2>Tout ce dont vous avez besoin</h2>
    <p>Une technologie de pointe pour une expérience de jeu sans friction</p>
  </div>
  <div class="features-grid">
    <?php
    $features = [
      ['<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>','Latence ultra-faible','Moins de 20ms grâce à notre infrastructure distribuée, peu importe votre localisation.'],
      ['<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>','4K 144 FPS',"Qualité d'image exceptionnelle jusqu'en 4K Ultra HD à 144 FPS, sur n'importe quel écran."],
      ['<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>','Multi-appareils',"PC, Mac, TV, smartphone — reprenez votre partie là où vous l'avez laissée."],
      ['<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>','Sauvegardes cloud','Vos sauvegardes sont synchronisées automatiquement. Ne perdez plus jamais votre progression.'],
      ['<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><path d="M9 8h6M12 6v4"/></svg>','Compatible manettes','DualSense, Xbox Series, contrôleurs Bluetooth — plug & play garanti.'],
      ['<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>','Sans engagement','Résiliez quand vous voulez. Nos abonnements sont flexibles, sans frais cachés.'],
    ];
    foreach ($features as [$icon,$title,$desc]): ?>
      <div class="feature-card">
        <div class="feature-icon"><?= $icon ?></div>
        <h3><?= htmlspecialchars($title) ?></h3>
        <p><?= htmlspecialchars($desc) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ═══════════════════════════════ CTA ════════════════════ -->
<section class="cta-band" style="background:var(--bg-surface);border-top:1px solid var(--border)">
  <div class="glow-bar"></div>
  <h2>Prêt à jouer ?</h2>
  <p>Rejoignez des milliers de joueurs qui profitent déjà de Nebula. Commencez gratuitement.</p>
  <div class="cta-actions">
    <a href="/NEBULA/auth.php?tab=register" class="btn btn-primary btn-lg">Créer un compte gratuit</a>
    <a href="/NEBULA/offres.php" class="btn btn-outline btn-lg">Voir les offres</a>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
