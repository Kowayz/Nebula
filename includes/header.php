<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Logout inline — plus besoin de logout.php
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: /NEBULA/index.php');
    exit;
}

$currentPage = basename($_SERVER['PHP_SELF'], '.php');

$pageCSS = $pageCSS ?? [];
$pageJS  = $pageJS  ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' — Nebula' : 'Nebula — Cloud Gaming' ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDesc ?? 'Jouez à vos jeux préférés en streaming haute qualité, sur tous vos appareils.') ?>">

  <link rel="stylesheet" href="/NEBULA/css/base.css">

  <?php foreach ($pageCSS as $sheet): ?>
  <link rel="stylesheet" href="/NEBULA/css/<?= htmlspecialchars($sheet) ?>.css">
  <?php endforeach; ?>
</head>
<body>

<nav class="navbar" id="navbar">

  <!-- Brand -->
  <a class="navbar-brand" href="/NEBULA/index.php">
    <svg class="logo-icon" viewBox="0 0 36 36" fill="none">
      <defs>
        <linearGradient id="c-grad" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" stop-color="#f472b6" />
          <stop offset="50%" stop-color="#7c3aed" />
          <stop offset="100%" stop-color="#c4b5fd" />
        </linearGradient>
        <filter id="c-glow" x="-50%" y="-50%" width="200%" height="200%">
          <feGaussianBlur stdDeviation="2.5" result="blur" />
          <feMerge>
            <feMergeNode in="blur" />
            <feMergeNode in="SourceGraphic" />
          </feMerge>
        </filter>
      </defs>

      <!-- Ambient Glow Background -->
      <g fill="url(#c-grad)" filter="url(#c-glow)" opacity="0.45">
        <circle cx="12" cy="17" r="4.5" />
        <circle cx="18" cy="13" r="6" />
        <circle cx="24" cy="16" r="5" />
        <rect x="4" y="17" width="28" height="9" rx="4.5" />
        <rect x="6" y="21" width="8" height="8" rx="3.5" />
        <rect x="22" y="21" width="8" height="8" rx="3.5" />
      </g>

      <!-- Main Body -->
      <g fill="url(#c-grad)">
        <circle cx="12" cy="17" r="4.5" />
        <circle cx="18" cy="13" r="6" />
        <circle cx="24" cy="16" r="5" />
        <rect x="4" y="17" width="28" height="9" rx="4.5" />
        <rect x="6" y="21" width="8" height="8" rx="3.5" />
        <rect x="22" y="21" width="8" height="8" rx="3.5" />
      </g>

      <!-- Cutout Details -->
      <g fill="#0b041a">
        <rect x="9" y="19.5" width="1.6" height="4.6" rx="0.4" />
        <rect x="7.5" y="21" width="4.6" height="1.6" rx="0.4" />
        <circle cx="24" cy="23" r="1.2" />
        <circle cx="27" cy="20" r="1.2" />
        <polygon points="16.5,18.5 20,20.5 16.5,22.5" />
      </g>
    </svg>
    <span class="brand-name">Nebula</span>
  </a>

  <!-- Desktop nav links -->
  <ul class="navbar-links" id="navLinks">
    <li><a href="/NEBULA/jeux.php"  <?= $currentPage==='jeux'   ? 'class="active"':'' ?>>Jeux</a></li>
    <li><a href="/NEBULA/offres.php"<?= $currentPage==='offres' ? 'class="active"':'' ?>>Tarifs</a></li>
    <li><a href="/NEBULA/demo.php"  <?= $currentPage==='demo'   ? 'class="active"':'' ?>>Démo</a></li>
    <li><a href="/NEBULA/faq.php"   <?= $currentPage==='faq'    ? 'class="active"':'' ?>>FAQ</a></li>
  </ul>

  <!-- Desktop actions -->
  <div class="navbar-actions" id="navActions">
    <a href="/NEBULA/panier.php" class="navbar-cart" aria-label="Panier">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
      <?php if (!empty($_SESSION['panier'])): ?>
        <span class="navbar-cart-dot"></span>
      <?php endif; ?>
    </a>
    <?php if (!empty($_SESSION['user_id'])): ?>
      <a href="/NEBULA/dashboard.php" class="btn btn-ghost btn-sm">Mon espace</a>
      <a href="?logout=1"             class="btn btn-outline btn-sm">Déconnexion</a>
    <?php else: ?>
      <a href="/NEBULA/auth.php"               class="btn btn-ghost btn-sm">Se connecter</a>
      <a href="/NEBULA/auth.php?tab=register"  class="btn btn-primary btn-sm">Commencer</a>
    <?php endif; ?>
  </div>

  <!-- Hamburger (mobile only) -->
  <button class="navbar-hamburger" id="hamburger" aria-label="Menu" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>

</nav>

<!-- Mobile panel -->
<div class="navbar-panel" id="navPanel">
  <ul class="navbar-panel-links">
    <li><a href="/NEBULA/jeux.php"  <?= $currentPage==='jeux'   ? 'class="active"':'' ?>>Jeux</a></li>
    <li><a href="/NEBULA/offres.php"<?= $currentPage==='offres' ? 'class="active"':'' ?>>Tarifs</a></li>
    <li><a href="/NEBULA/demo.php"  <?= $currentPage==='demo'   ? 'class="active"':'' ?>>Démo</a></li>
    <li><a href="/NEBULA/faq.php"   <?= $currentPage==='faq'    ? 'class="active"':'' ?>>FAQ</a></li>
  </ul>
  <div class="navbar-panel-actions">
    <a href="/NEBULA/panier.php" class="btn btn-ghost btn-sm" style="display:flex;align-items:center;gap:8px">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
      Panier<?php if (!empty($_SESSION['panier'])): ?> <span style="background:linear-gradient(135deg,#9f1239,#7c3aed);border-radius:10px;padding:1px 7px;font-size:.65rem;font-weight:700">1</span><?php endif; ?>
    </a>
    <?php if (!empty($_SESSION['user_id'])): ?>
      <a href="/NEBULA/dashboard.php" class="btn btn-outline btn-sm">Mon espace</a>
      <a href="?logout=1"             class="btn btn-ghost btn-sm">Déconnexion</a>
    <?php else: ?>
      <a href="/NEBULA/auth.php"              class="btn btn-ghost btn-sm">Se connecter</a>
      <a href="/NEBULA/auth.php?tab=register" class="btn btn-primary btn-sm btn-full">Commencer</a>
    <?php endif; ?>
  </div>
</div>

<div class="navbar-overlay" id="navOverlay"></div>

