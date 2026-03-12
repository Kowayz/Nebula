<?php
require 'includes/auth_check.php';
require 'includes/db.php';

$pageTitle = 'Mon espace';
$pageCSS   = ['dashboard'];
$pageJS    = [];

$pdo    = getPDO();
$userId = (int)$_SESSION['user_id'];

$stmtUser = $pdo->prepare('SELECT * FROM utilisateur WHERE id_user = :id');
$stmtUser->execute([':id' => $userId]);
$user = $stmtUser->fetch();

if (!$user) {
    session_destroy();
    header('Location: /NEBULA/auth.php');
    exit;
}

try {
    $stmtCmds = $pdo->prepare(
        'SELECT c.id_commande, c.date_commande, c.total_ttc, c.statut, o.nom_offre
         FROM commande c
         LEFT JOIN offre o ON c.id_offre = o.id_offre
         WHERE c.id_user = :id
         ORDER BY c.date_commande DESC
         LIMIT 10'
    );
    $stmtCmds->execute([':id' => $userId]);
    $commandes = $stmtCmds->fetchAll();
} catch (Exception $e) {
    $commandes = [];
}

try {
    $jeux = $pdo->query('SELECT * FROM jeu LIMIT 6')->fetchAll();
} catch (Exception $e) {
    $jeux = [];
}

$abonnement = null;
foreach ($commandes as $cmd) {
    if (!empty($cmd['nom_offre']) && $cmd['statut'] === 'payee') {
        $abonnement = $cmd;
        break;
    }
}

$nbCommandes  = count($commandes);
$planName     = $abonnement ? $abonnement['nom_offre'] : 'Starter';
$planGradient = [
    'Starter' => 'linear-gradient(135deg,#374151,#1f2937)',
    'Gamer'   => 'linear-gradient(135deg,#7c3aed,#4c1d95)',
    'Ultra'   => 'linear-gradient(135deg,#9f1239,#7c3aed)',
][$planName] ?? 'linear-gradient(135deg,#374151,#1f2937)';

require 'includes/header.php';
?>

<div class="dashboard-page">

  <!-- ── Hero banner ── -->
  <div class="db-hero">
    <div class="db-hero-orb db-hero-orb-a"></div>
    <div class="db-hero-orb db-hero-orb-b"></div>

    <div class="db-hero-inner">
      <!-- Avatar -->
      <div class="db-hero-avatar">
        <?= mb_strtoupper(mb_substr($user['nom'], 0, 1)) ?>
      </div>

      <!-- Info -->
      <div class="db-hero-info">
        <div class="db-hero-welcome">Bienvenue sur Nebula</div>
        <div class="db-hero-name"><?= htmlspecialchars($user['nom']) ?></div>
        <div class="db-hero-email"><?= htmlspecialchars($user['email']) ?></div>
      </div>

      <!-- Plan badge -->
      <div class="db-hero-plan" style="background:<?= $planGradient ?>">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        Plan <?= htmlspecialchars($planName) ?>
      </div>
    </div>
  </div>

  <!-- ── Main layout ── -->
  <div class="db-layout">

    <!-- Stats row -->
    <div class="db-stats-row">
      <div class="db-stat-card">
        <div class="db-stat-icon" style="background:linear-gradient(135deg,rgba(124,58,237,.5),rgba(124,58,237,.2))">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><path d="M9 8h6M12 6v4"/></svg>
        </div>
        <div>
          <div class="db-stat-num">—</div>
          <div class="db-stat-label">Jeux joués</div>
        </div>
      </div>
      <div class="db-stat-card">
        <div class="db-stat-icon" style="background:linear-gradient(135deg,rgba(159,18,57,.5),rgba(159,18,57,.2))">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        </div>
        <div>
          <div class="db-stat-num"><?= $nbCommandes ?></div>
          <div class="db-stat-label">Commandes</div>
        </div>
      </div>
      <div class="db-stat-card">
        <div class="db-stat-icon" style="background:linear-gradient(135deg,rgba(244,114,182,.4),rgba(244,114,182,.15))">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
          <div class="db-stat-num">—</div>
          <div class="db-stat-label">Heures jouées</div>
        </div>
      </div>
      <div class="db-stat-card">
        <div class="db-stat-icon" style="background:<?= $planGradient ?>">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div>
          <div class="db-stat-num"><?= htmlspecialchars($planName) ?></div>
          <div class="db-stat-label">Abonnement</div>
        </div>
      </div>
    </div>

    <!-- Main columns -->
    <div class="db-main-cols">

      <!-- Left column -->
      <div class="db-left-col">

        <!-- Library -->
        <div class="db-card">
          <div class="db-card-head">
            <div class="db-card-title">Ma bibliothèque</div>
            <a href="/NEBULA/jeux.php" class="db-card-link">
              Voir tout
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
          </div>

          <?php if (empty($jeux)): ?>
            <div class="db-empty">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 10px;color:var(--text-faint)"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
              <div>Aucun jeu dans votre bibliothèque pour le moment.</div>
              <a href="/NEBULA/jeux.php" class="btn btn-outline btn-sm" style="margin-top:12px">Parcourir les jeux</a>
            </div>
          <?php else: ?>
            <div class="db-games-grid">
              <?php foreach ($jeux as $j): ?>
                <a href="/NEBULA/jeux.php" class="db-game-thumb">
                  <?php if (!empty($j['image_url'])): ?>
                    <img src="/NEBULA/<?= htmlspecialchars($j['image_url']) ?>"
                         alt="<?= htmlspecialchars($j['titre']) ?>" loading="lazy">
                  <?php else: ?>
                    <div class="db-game-thumb-placeholder">
                      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><path d="M9 8h6M12 6v4"/></svg>
                    </div>
                  <?php endif; ?>
                  <div class="db-game-thumb-overlay">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                  </div>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Commandes -->
        <div class="db-card">
          <div class="db-card-head">
            <div class="db-card-title">Historique des commandes</div>
          </div>

          <?php if (empty($commandes)): ?>
            <div class="db-empty">Aucune commande pour le moment.</div>
          <?php else: ?>
            <div class="orders-list">
              <?php foreach ($commandes as $cmd): ?>
                <div class="order-row">
                  <div>
                    <div class="order-name"><?= htmlspecialchars($cmd['nom_offre'] ?? 'Commande') ?> #<?= $cmd['id_commande'] ?></div>
                    <div class="order-date"><?= date('d/m/Y', strtotime($cmd['date_commande'])) ?></div>
                  </div>
                  <div class="order-right">
                    <div class="order-price"><?= number_format($cmd['total_ttc'], 2, ',', ' ') ?> €</div>
                    <?php
                    $statut  = $cmd['statut'];
                    $classes = ['payee'=>'status-payee','en attente'=>'status-attente','annulee'=>'status-annulee'];
                    $cls = $classes[$statut] ?? 'status-attente';
                    ?>
                    <span class="status-badge <?= $cls ?>"><?= htmlspecialchars(ucfirst($statut)) ?></span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>

      </div><!-- /.db-left-col -->

      <!-- Right column -->
      <div class="db-right-col">

        <!-- Abonnement -->
        <div class="db-card">
          <div class="db-card-head">
            <div class="db-card-title">Mon abonnement</div>
          </div>

          <?php if ($abonnement): ?>
            <div class="db-sub-band" style="background:<?= $planGradient ?>">
              <div class="db-sub-band-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              </div>
              <div class="db-sub-name"><?= htmlspecialchars($abonnement['nom_offre']) ?></div>
              <div class="db-sub-price"><?= number_format($abonnement['total_ttc'], 2, ',', ' ') ?> €/mois</div>
            </div>
            <div class="db-sub-meta" style="margin-bottom:16px">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              Actif depuis le <?= date('d/m/Y', strtotime($abonnement['date_commande'])) ?>
            </div>
            <div class="db-sub-badge" style="margin-bottom:16px">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Actif
            </div>
            <a href="/NEBULA/offres.php" class="btn btn-outline btn-full btn-sm">Changer d'offre</a>
          <?php else: ?>
            <div class="sub-empty-card">
              <div class="sub-empty-title">Aucun abonnement actif</div>
              <div class="sub-empty-sub">Choisissez une offre pour accéder à votre bibliothèque complète.</div>
              <a href="/NEBULA/offres.php" class="btn btn-primary btn-full btn-sm">Voir les offres</a>
            </div>
          <?php endif; ?>
        </div>

        <!-- Accès rapides -->
        <div class="db-card">
          <div class="db-card-head">
            <div class="db-card-title">Accès rapides</div>
          </div>
          <div class="db-quick-links">
            <a href="/NEBULA/jeux.php" class="db-quick-link">
              <div class="db-quick-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><path d="M9 8h6M12 6v4"/></svg>
              </div>
              <span class="db-quick-label">Bibliothèque de jeux</span>
              <svg class="db-quick-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
            <a href="/NEBULA/offres.php" class="db-quick-link">
              <div class="db-quick-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              </div>
              <span class="db-quick-label">Changer d'offre</span>
              <svg class="db-quick-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
            <a href="/NEBULA/configurateur.php" class="db-quick-link">
              <div class="db-quick-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
              </div>
              <span class="db-quick-label">Configurateur bouquet</span>
              <svg class="db-quick-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
            <a href="/NEBULA/contact.php" class="db-quick-link">
              <div class="db-quick-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              </div>
              <span class="db-quick-label">Support & Contact</span>
              <svg class="db-quick-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
            <a href="?logout=1" class="db-quick-link">
              <div class="db-quick-icon" style="background:rgba(239,68,68,.1);border-color:rgba(239,68,68,.2)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
              </div>
              <span class="db-quick-label" style="color:var(--danger)">Déconnexion</span>
              <svg class="db-quick-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
          </div>
        </div>

      </div><!-- /.db-right-col -->

    </div><!-- /.db-main-cols -->

  </div><!-- /.db-layout -->

</div><!-- /.dashboard-page -->

<?php require 'includes/footer.php'; ?>
