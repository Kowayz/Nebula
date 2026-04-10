<?php
require 'includes/db.php';

$pageTitle = 'Jouez à vos jeux n\'importe où';
$pageCSS   = ['index'];
$pageJS    = [];

require_once 'includes/igdb.php';

$topGames = [];
try {
    $token = igdb_token();
    if ($token) {
        $fields  = "fields id,name,summary,genres.name,cover.url,artworks.url,screenshots.url,rating_count,hypes; where cover != null & hypes > 50; sort hypes desc; limit 3;";
        $res = igdb_query('games', $fields, $token);
        if (count($res) < 3) {
            $res = igdb_query('games', "fields id,name,summary,genres.name,cover.url,artworks.url,screenshots.url,rating_count; where cover != null & rating > 85; sort rating_count desc; limit 3;", $token);
        }
        foreach ($res as $g) {
            $mapped = igdb_map($g);
            $mapped['featured_url'] = isset($g['screenshots'][0]) ? igdb_cover($g['screenshots'][0]['url'], 't_1080p') : (isset($g['artworks'][0]) ? igdb_cover($g['artworks'][0]['url'], 't_1080p') : igdb_cover($g['cover']['url'] ?? null, 't_cover_big'));
            $mapped['logo_url'] = igdb_logo($g['name']);
            $topGames[] = $mapped;
        }
    }
} catch (Exception $e) {}

// Fallback BDD
if (count($topGames) < 3) {
    try {
        $pdo = getPDO();
        $stmt = $pdo->query('SELECT * FROM jeu ORDER BY id_jeu LIMIT 3');
        foreach ($stmt->fetchAll() as $g) {
            $topGames[] = ['id_jeu' => $g['id_jeu'], 'titre' => $g['titre'], 'genre' => $g['genre'], 'featured_url' => $g['image_url'], 'logo_url' => null];
        }
    } catch (Exception $e) {}
}

require 'includes/header.php';
?>

<!-- ═══════════════════════════════ HERO ═══════════════════ -->
<section class="hero">
  <h1>Jouez à vos jeux<br><span class="gradient-text">n'importe où</span></h1>
  <p>Profitez de vos jeux préférés en streaming haute qualité sans téléchargement, sur tous vos appareils</p>

  <div class="hero-actions">
    <a href="/NEBULA/auth.php?tab=register" class="btn btn-primary btn-lg">
      <img src="/NEBULA/public/assets/img/icons/platforms/bouton-play.png" alt="icon" width="16" height="16" class="icon-img">
      Commencer gratuitement
    </a>
    <a href="/NEBULA/demo.php" class="btn btn-outline btn-lg">Voir la démo</a>
  </div>

  <div class="hero-stats">
    <div class="hero-stat">
      <span class="stat-icon">
        <img src="/NEBULA/public/assets/img/icons/ecommerce/serveur.png" alt="icon" width="22" height="22" class="icon-img">
      </span>
      <div><span class="stat-value">4K Ultra HD</span><span class="stat-label">Résolution maximale</span></div>
    </div>
    <div class="hero-stat">
      <span class="stat-icon">
        <img src="/NEBULA/public/assets/img/icons/ecommerce/coche-incluse.png" alt="icon" width="22" height="22" class="icon-img">
      </span>
      <div><span class="stat-value">144 FPS</span><span class="stat-label">Fluidité maximale</span></div>
    </div>
    <div class="hero-stat">
      <span class="stat-icon">
        <img src="/NEBULA/public/assets/img/icons/dashboard/horloge.png" alt="icon" width="14" height="14" class="icon-img">
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

  <div class="games-showcase">
    <?php if (count($topGames) > 0): 
      $spotlight = $topGames[0];
    ?>
    <a href="/NEBULA/produit.php?id=<?= $spotlight['id_jeu'] ?>" class="game-spotlight">
      <img class="game-spotlight-img" src="<?= htmlspecialchars($spotlight['featured_url'] ?? '') ?>" alt="">
      <div class="game-spotlight-overlay">
        <div class="game-spotlight-top">
          <div class="gs-badge">Jeu inclus</div>
          <div class="gs-live">En direct</div>
        </div>
        <div class="game-spotlight-bottom">
          <div>
            <?php if (!empty($spotlight['logo_url'])): ?>
              <img src="<?= htmlspecialchars($spotlight['logo_url']) ?>" alt="<?= htmlspecialchars($spotlight['titre']) ?>" class="gs-logo">
            <?php else: ?>
              <div class="gs-title"><?= htmlspecialchars($spotlight['titre']) ?></div>
            <?php endif; ?>
          </div>
          <div class="gs-actions">
            <div class="gs-platforms">
              <img src="/NEBULA/public/assets/img/icons/platforms/windows.png" alt="icon" width="16" height="16" class="icon-img" style="opacity:0.6">
            </div>
            <div class="gs-cta">
              <img src="/NEBULA/public/assets/img/icons/platforms/bouton-play.png" alt="icon" width="14" height="14" class="icon-img"> Jouer
            </div>
          </div>
        </div>
      </div>
    </a>
    <?php endif; ?>

    <div class="game-posters">
      <?php for($i = 1; $i < count($topGames); $i++): 
        $poster = $topGames[$i];
      ?>
      <a href="/NEBULA/produit.php?id=<?= $poster['id_jeu'] ?>" class="game-poster">
        <img class="game-poster-img" src="<?= htmlspecialchars($poster['featured_url'] ?? '') ?>" alt="">
        <div class="game-poster-overlay">
          <div class="gp-badge">Populaire</div>
          <?php if (!empty($poster['logo_url'])): ?>
            <img src="<?= htmlspecialchars($poster['logo_url']) ?>" alt="<?= htmlspecialchars($poster['titre']) ?>" class="gp-logo">
          <?php else: ?>
            <div class="gp-title"><?= htmlspecialchars($poster['titre']) ?></div>
          <?php endif; ?>
          <div class="gp-cta">
            <img src="/NEBULA/public/assets/img/icons/platforms/bouton-play.png" alt="icon" width="12" height="12" class="icon-img"> Jouer
          </div>
        </div>
      </a>
      <?php endfor; ?>
    </div>
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
      ['<img src="/NEBULA/public/assets/img/icons/ecommerce/coche-incluse.png" alt="icon" width="22" height="22" class="icon-img">','Latence ultra-faible','Moins de 20ms grâce à notre infrastructure distribuée, peu importe votre localisation.'],
      ['<img src="/NEBULA/public/assets/img/icons/contact/localisation.png" alt="icon" width="20" height="20" class="icon-img">','4K 144 FPS',"Qualité d'image exceptionnelle jusqu'en 4K Ultra HD à 144 FPS, sur n'importe quel écran."],
      ['<img src="/NEBULA/public/assets/img/icons/platforms/nintendo.png" alt="icon" width="24" height="24" class="platform-icon">','Multi-appareils',"PC, Mac, TV, smartphone — reprenez votre partie là où vous l'avez laissée."],
      ['<img src="/NEBULA/public/assets/img/icons/ecommerce/serveur.png" alt="icon" width="20" height="20" class="icon-img">','Sauvegardes cloud','Vos sauvegardes sont synchronisées automatiquement. Ne perdez plus jamais votre progression.'],
      ['<img src="/NEBULA/public/assets/img/icons/ecommerce/serveur.png" alt="icon" width="22" height="22" class="icon-img">','Compatible manettes','DualSense, Xbox Series, contrôleurs Bluetooth — plug & play garanti.'],
      ['<img src="/NEBULA/public/assets/img/icons/contact/document-legal.png" alt="icon" width="22" height="22" class="icon-img">','Sans engagement','Résiliez quand vous voulez. Nos abonnements sont flexibles, sans frais cachés.'],
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
