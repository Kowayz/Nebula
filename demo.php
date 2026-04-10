<?php
$pageTitle = 'Démo — Essayez Nebula';
$pageCSS   = ['demo'];
$pageJS    = [];
require 'includes/header.php';
?>

<main class="demo-main">

<!-- ══════════════════════════ HERO ══════════════════════════ -->
<section class="demo-hero">
  <div class="demo-hero-bg">
    <div class="demo-hero-orb demo-orb-1"></div>
    <div class="demo-hero-orb demo-orb-2"></div>
    <div class="demo-hero-orb demo-orb-3"></div>
    <div class="demo-hero-grid"></div>
  </div>

  <div class="demo-hero-content">
    <div class="demo-hero-tag">Démo interactive</div>
    <h1 class="demo-hero-title">Jouez en <span class="demo-gradient-text">30 secondes</span></h1>
    <p class="demo-hero-sub">Aucune installation, aucune carte bancaire. Lancez votre première session de cloud gaming directement depuis votre navigateur.</p>

    <div class="demo-stats-bar">
      <div class="demo-stat">
        <span class="demo-stat-value">&lt; 20<span class="demo-hud-unit">ms</span></span>
        <span class="demo-stat-label">Latence</span>
      </div>
      <div class="demo-stat">
        <span class="demo-stat-value">4K</span>
        <span class="demo-stat-label">Résolution</span>
      </div>
      <div class="demo-stat">
        <span class="demo-stat-value">144<span class="demo-hud-unit">fps</span></span>
        <span class="demo-stat-label">Fluidité</span>
      </div>
      <div class="demo-stat">
        <span class="demo-stat-value">+200</span>
        <span class="demo-stat-label">Jeux</span>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════ BROWSER PREVIEW ══════════════════════════ -->
<div class="demo-preview-section">
  <div class="demo-browser">

    <!-- Top bar -->
    <div class="demo-browser-bar">
      <div class="demo-browser-dots">
        <span class="demo-dot demo-dot-red"></span>
        <span class="demo-dot demo-dot-yellow"></span>
        <span class="demo-dot demo-dot-green"></span>
      </div>
      <div class="demo-browser-url">
        <span class="demo-url-icon">
          <img src="/NEBULA/public/assets/img/icons/ecommerce/bouclier-securite.png" alt="icon" width="14" height="14" class="icon-img">
        </span>
        nebula.gg/play/elden-ring
      </div>
      <div class="demo-browser-pills">
        <span class="demo-pill">4K · 144 FPS</span>
        <span class="demo-pill demo-pill-green">En ligne</span>
      </div>
    </div>

    <!-- Game viewport -->
    <div class="demo-viewport">
      <div class="demo-game-scene">
        <div class="demo-scene-layer demo-scene-sky"></div>
        <div class="demo-scene-layer demo-scene-mid"></div>
        <div class="demo-scene-layer demo-scene-fg"></div>
        <div class="demo-scene-layer demo-scene-scanlines"></div>
        <div class="demo-scene-layer demo-scene-vignette"></div>
      </div>

      <!-- HUD top-left -->
      <div class="demo-hud demo-hud-tl">
        <div class="demo-hud-pill">
          <span class="demo-hud-dot"></span>
          Connecté — Paris
        </div>
      </div>

      <!-- HUD top-right -->
      <div class="demo-hud demo-hud-tr">
        <div class="demo-hud-stat">
          <span class="demo-hud-stat-val demo-val-green">12<span class="demo-hud-unit">ms</span></span>
          <span class="demo-hud-stat-key">LATENCE</span>
        </div>
        <div class="demo-hud-stat">
          <span class="demo-hud-stat-val">144<span class="demo-hud-unit">fps</span></span>
          <span class="demo-hud-stat-key">FPS</span>
        </div>
        <div class="demo-hud-stat">
          <span class="demo-hud-stat-val">4K</span>
          <span class="demo-hud-stat-key">QUALITÉ</span>
        </div>
      </div>

      <!-- HUD bottom-left -->
      <div class="demo-hud demo-hud-bl">
        <div class="demo-hud-bar">
          <img src="/NEBULA/public/assets/img/icons/ecommerce/serveur.png" alt="icon" width="22" height="22" class="icon-img">
          DualSense détecté
        </div>
      </div>

      <!-- Play button overlay -->
      <div class="demo-play-center">
        <div class="demo-play-rings">
          <div class="demo-play-ring demo-ring-1"></div>
          <div class="demo-play-ring demo-ring-2"></div>
        </div>
        <a href="/NEBULA/auth.php?tab=register" class="demo-play-btn">
          <img src="/NEBULA/public/assets/img/icons/platforms/bouton-play.png" alt="icon" width="16" height="16" class="icon-img">
        </a>
        <span class="demo-play-label">Démarrer la démo</span>
      </div>
    </div>

    <!-- Bottom bar -->
    <div class="demo-browser-bottom">
      <div class="demo-bottom-info">
        <span class="demo-bottom-dot"></span>
        <span class="demo-bottom-game">Elden Ring</span>
        <span class="demo-bottom-genre">Action-RPG · FromSoftware</span>
      </div>
      <div class="demo-bottom-actions">
        <div class="demo-icon-btn" title="Paramètres">
          <img src="/NEBULA/public/assets/img/icons/nav/fleche-droite.png" alt="icon" width="20" height="20" class="icon-img">
        </div>
        <div class="demo-icon-btn" title="Plein écran">
          <img src="/NEBULA/public/assets/img/icons/nav/fleche-droite.png" alt="icon" width="20" height="20" class="icon-img">
        </div>
        <div class="demo-icon-btn" title="Son">
          <img src="/NEBULA/public/assets/img/icons/nav/fleche-droite.png" alt="icon" width="20" height="20" class="icon-img">
        </div>
      </div>
    </div>

  </div>
</div>

<!-- ══════════════════════════ STEPS ══════════════════════════ -->
<section class="demo-steps-section">
  <div class="demo-steps-inner">
    <div class="demo-section-tag">Comment démarrer</div>
    <h2 class="demo-section-title">En 3 étapes, vous jouez</h2>

    <div class="demo-steps-row">
      <?php
      $steps = [
        [
          'title' => 'Créer un compte',
          'desc'  => "Inscrivez-vous en moins d'une minute avec votre e-mail. Aucune carte bancaire requise pour commencer.",
          'icon'  => '<img src="/NEBULA/public/assets/img/icons/contact/email.png" alt="icon" width="20" height="20" class="icon-img">',
        ],
        [
          'title' => 'Choisir un jeu',
          'desc'  => 'Parcourez +200 titres disponibles instantanément. Filtrez par genre, popularité ou nouveautés.',
          'icon'  => '<img src="/NEBULA/public/assets/img/icons/ecommerce/serveur.png" alt="icon" width="22" height="22" class="icon-img">',
        ],
        [
          'title' => 'Jouer immédiatement',
          'desc'  => "Le jeu démarre en quelques secondes dans votre navigateur. Aucun téléchargement, aucune installation.",
          'icon'  => '<img src="/NEBULA/public/assets/img/icons/platforms/bouton-play.png" alt="icon" width="16" height="16" class="icon-img">',
        ],
      ];
      foreach ($steps as $i => $step): ?>
      <div class="demo-step">
        <?php if ($i < count($steps) - 1): ?>
          <div class="demo-step-line"></div>
        <?php endif; ?>
        <div class="demo-step-num"><?= $i + 1 ?></div>
        <div class="demo-step-icon"><?= $step['icon'] ?></div>
        <h3 class="demo-step-title"><?= htmlspecialchars($step['title']) ?></h3>
        <p class="demo-step-desc"><?= htmlspecialchars($step['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════ CTA ══════════════════════════ -->
<section class="demo-cta">
  <div class="demo-cta-glow"></div>
  <div class="demo-cta-grid"></div>
  <div class="demo-cta-content">
    <h2 class="demo-cta-title">Prêt pour votre <span class="demo-gradient-text">première session</span> ?</h2>
    <p class="demo-cta-sub">Rejoignez des milliers de joueurs qui jouent déjà sans télécharger quoi que ce soit.</p>
    <div class="demo-cta-actions">
      <a href="/NEBULA/auth.php?tab=register" class="btn btn-primary btn-lg">
        <img src="/NEBULA/public/assets/img/icons/platforms/bouton-play.png" alt="icon" width="16" height="16" class="icon-img">
        Commencer gratuitement
      </a>
      <a href="/NEBULA/jeux.php" class="btn btn-outline btn-lg">Parcourir le catalogue</a>
    </div>
  </div>
</section>

</main>

<?php require 'includes/footer.php'; ?>
