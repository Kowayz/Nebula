<?php
$pageTitle = 'Mentions légales';
$pageCSS   = ['mentions'];
$pageJS    = [];
require 'includes/header.php';
?>

<div class="ml-page">

<!-- ══════════════════════════ HERO ══════════════════════════ -->
<div class="ml-hero">
  <div class="ml-hero-orb ml-hero-orb-a"></div>
  <div class="ml-hero-orb ml-hero-orb-b"></div>
  <div class="ml-hero-orb ml-hero-orb-c"></div>
  <div class="ml-hero-inner">
    <div class="ml-hero-tag">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
      Légal
    </div>
    <h1 class="ml-hero-title">Mentions <span class="gradient-text">légales</span></h1>
    <p class="ml-hero-sub">Informations légales, conditions d'utilisation et politique de confidentialité de la plateforme Nebula.</p>
    <span class="ml-hero-date">Mise à jour : 1er janvier 2026</span>
  </div>
</div>

<!-- ══════════════════════════ LAYOUT ══════════════════════════ -->
<div class="ml-wrap">

  <!-- Sidebar nav -->
  <aside class="ml-sidebar">
    <nav class="ml-nav-card">
      <div class="ml-nav-heading">Sections</div>

      <?php
      $navItems = [
        ['editeur',        'building', '01', 'Éditeur du site'],
        ['hebergement',    'globe',    '02', 'Hébergement'],
        ['propriete',      'copy',     '03', 'Propriété intellectuelle'],
        ['donnees',        'lock',     '04', 'Données personnelles'],
        ['cookies',        'cookie',   '05', 'Politique de cookies'],
        ['responsabilite', 'scale',    '06', 'Responsabilité'],
        ['contact-legal',  'mail',     '07', 'Contact légal'],
      ];
      $icons = [
        'building' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 22V12h6v10M3 9h18"/></svg>',
        'globe'    => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
        'copy'     => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>',
        'lock'     => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
        'cookie'   => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"/><path d="M8.5 8.5v.01"/><path d="M16 15.5v.01"/><path d="M12 12v.01"/></svg>',
        'scale'    => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18M3 9l9-6 9 6"/><path d="M3 9h6l3 9 3-9h6"/></svg>',
        'mail'     => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
      ];
      foreach ($navItems as [$id, $iconKey, $num, $label]): ?>
      <a href="#<?= $id ?>" class="ml-nav-link">
        <span class="ml-nav-num"><?= $num ?></span>
        <span class="ml-nav-icon"><?= $icons[$iconKey] ?></span>
        <span class="ml-nav-label"><?= htmlspecialchars($label) ?></span>
        <span class="ml-nav-arrow">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </span>
      </a>
      <?php endforeach; ?>

      <div class="ml-nav-footer">
        <span class="ml-nav-footer-icon">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </span>
        <p>Conforme RGPD &amp; loi française</p>
      </div>
    </nav>
  </aside>

  <!-- Main content -->
  <main class="ml-content">

    <!-- 1. Éditeur -->
    <div class="ml-card" id="editeur">
      <div class="ml-card-head">
        <div class="ml-card-icon-wrap">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 22V12h6v10M3 9h18"/></svg>
        </div>
        <div>
          <span class="ml-card-num">01</span>
          <h2 class="ml-card-title">Éditeur du site</h2>
        </div>
      </div>
      <div class="ml-card-body">
        <div class="ml-kv-grid">
          <div class="ml-kv-row"><span class="ml-kv-key">Raison sociale</span><span class="ml-kv-val">Nebula SAS</span></div>
          <div class="ml-kv-row"><span class="ml-kv-key">Capital social</span><span class="ml-kv-val">10 000 €</span></div>
          <div class="ml-kv-row"><span class="ml-kv-key">Siège social</span><span class="ml-kv-val">1 rue des Étoiles, 75001 Paris, France</span></div>
          <div class="ml-kv-row"><span class="ml-kv-key">SIRET</span><span class="ml-kv-val">000 000 000 00000</span></div>
          <div class="ml-kv-row"><span class="ml-kv-key">N° TVA intracommunautaire</span><span class="ml-kv-val">FR 00 000000000</span></div>
          <div class="ml-kv-row"><span class="ml-kv-key">Directeur de publication</span><span class="ml-kv-val">Alexandre Martin</span></div>
          <div class="ml-kv-row"><span class="ml-kv-key">E-mail</span><span class="ml-kv-val"><a href="mailto:contact@nebula.gg" style="color:var(--accent)">contact@nebula.gg</a></span></div>
        </div>
      </div>
    </div>

    <!-- 2. Hébergement -->
    <div class="ml-card" id="hebergement">
      <div class="ml-card-head">
        <div class="ml-card-icon-wrap">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        </div>
        <div>
          <span class="ml-card-num">02</span>
          <h2 class="ml-card-title">Hébergement</h2>
        </div>
      </div>
      <div class="ml-card-body">
        <div class="ml-kv-grid">
          <div class="ml-kv-row"><span class="ml-kv-key">Hébergeur</span><span class="ml-kv-val">OVH SAS</span></div>
          <div class="ml-kv-row"><span class="ml-kv-key">Adresse</span><span class="ml-kv-val">2 rue Kellermann, 59100 Roubaix, France</span></div>
          <div class="ml-kv-row"><span class="ml-kv-key">Téléphone</span><span class="ml-kv-val">1007</span></div>
          <div class="ml-kv-row"><span class="ml-kv-key">Site web</span><span class="ml-kv-val"><a href="https://www.ovhcloud.com" target="_blank" rel="noopener" style="color:var(--accent)">www.ovhcloud.com</a></span></div>
        </div>
        <p class="ml-text">Les serveurs de streaming de jeux sont hébergés dans plusieurs datacenters européens certifiés ISO 27001, afin de garantir la disponibilité et la sécurité de vos données.</p>
      </div>
    </div>

    <!-- 3. Propriété intellectuelle -->
    <div class="ml-card" id="propriete">
      <div class="ml-card-head">
        <div class="ml-card-icon-wrap">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
        </div>
        <div>
          <span class="ml-card-num">03</span>
          <h2 class="ml-card-title">Propriété intellectuelle</h2>
        </div>
      </div>
      <div class="ml-card-body">
        <p class="ml-text">L'ensemble du contenu de ce site — textes, images, logos, icônes, vidéos, sons, logiciels et tout autre élément — est la propriété exclusive de Nebula SAS ou de ses partenaires, et est protégé par les lois françaises et internationales relatives à la propriété intellectuelle.</p>
        <p class="ml-text">Toute reproduction, distribution, modification, adaptation, retransmission ou publication, même partielle, de ces différents éléments est strictement interdite sans l'accord exprès par écrit de Nebula SAS.</p>
        <div class="ml-alert">
          <span class="ml-alert-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          </span>
          <p>Les noms et logos des jeux vidéo présents sur la plateforme restent la propriété de leurs éditeurs respectifs. Leur utilisation sur Nebula fait l'objet de licences commerciales en bonne et due forme.</p>
        </div>
      </div>
    </div>

    <!-- 4. Données personnelles -->
    <div class="ml-card" id="donnees">
      <div class="ml-card-head">
        <div class="ml-card-icon-wrap">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <div>
          <span class="ml-card-num">04</span>
          <h2 class="ml-card-title">Données personnelles</h2>
        </div>
      </div>
      <div class="ml-card-body">
        <p class="ml-text">Conformément au RGPD (UE 2016/679) et à la loi Informatique et Libertés, vous disposez des droits suivants :</p>
        <ul class="ml-rights">
          <?php
          $rights = [
            ['Droit d\'accès', 'Obtenir une copie de vos données personnelles'],
            ['Droit de rectification', 'Corriger des données inexactes ou incomplètes'],
            ['Droit à l\'effacement', 'Demander la suppression de vos données'],
            ['Droit à la portabilité', 'Récupérer vos données dans un format lisible'],
            ['Droit d\'opposition', 'Vous opposer au traitement de vos données'],
          ];
          foreach ($rights as $r): ?>
          <li class="ml-right-item">
            <div class="ml-right-check">
              <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div><strong style="color:var(--text-white)"><?= htmlspecialchars($r[0]) ?></strong> — <?= htmlspecialchars($r[1]) ?></div>
          </li>
          <?php endforeach; ?>
        </ul>
        <div class="ml-kv-grid" style="margin-top:16px">
          <div class="ml-kv-row"><span class="ml-kv-key">DPO (Protection des données)</span><span class="ml-kv-val"><a href="mailto:dpo@nebula.gg" style="color:var(--accent)">dpo@nebula.gg</a></span></div>
          <div class="ml-kv-row"><span class="ml-kv-key">Durée de conservation</span><span class="ml-kv-val">3 ans après la dernière activité</span></div>
        </div>
        <div class="ml-contact-hint">
          <p>Vous avez le droit de déposer une plainte auprès de la <strong><a href="https://www.cnil.fr" target="_blank" rel="noopener">CNIL</a></strong> — Commission Nationale de l'Informatique et des Libertés.</p>
        </div>
      </div>
    </div>

    <!-- 5. Cookies -->
    <div class="ml-card" id="cookies">
      <div class="ml-card-head">
        <div class="ml-card-icon-wrap">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"/><path d="M8.5 8.5v.01"/><path d="M16 15.5v.01"/><path d="M12 12v.01"/></svg>
        </div>
        <div>
          <span class="ml-card-num">05</span>
          <h2 class="ml-card-title">Politique de cookies</h2>
        </div>
      </div>
      <div class="ml-card-body">
        <p class="ml-text">Ce site utilise des cookies afin d'améliorer votre expérience utilisateur et de permettre son bon fonctionnement.</p>
        <div class="ml-table-wrap">
          <table class="ml-table">
            <thead>
              <tr>
                <th>Type</th>
                <th>Finalité</th>
                <th>Durée</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="ml-td-type">Essentiels</td>
                <td>Session utilisateur, sécurité du compte, panier</td>
                <td>Session</td>
              </tr>
              <tr>
                <td class="ml-td-type">Fonctionnels</td>
                <td>Préférences langue, qualité vidéo, manette</td>
                <td>1 an</td>
              </tr>
              <tr>
                <td class="ml-td-type">Analytiques</td>
                <td>Statistiques d'usage anonymisées (avec consentement)</td>
                <td>13 mois</td>
              </tr>
            </tbody>
          </table>
        </div>
        <p class="ml-text">Aucun cookie publicitaire ou de ciblage n'est déposé sans votre consentement explicite.</p>
      </div>
    </div>

    <!-- 6. Responsabilité -->
    <div class="ml-card" id="responsabilite">
      <div class="ml-card-head">
        <div class="ml-card-icon-wrap">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18M3 9l9-6 9 6"/><path d="M3 9h6l3 9 3-9h6"/></svg>
        </div>
        <div>
          <span class="ml-card-num">06</span>
          <h2 class="ml-card-title">Limitation de responsabilité</h2>
        </div>
      </div>
      <div class="ml-card-body">
        <p class="ml-text">Nebula SAS s'efforce de maintenir le service disponible 24h/24 et 7j/7. Cependant, la société ne pourra être tenue responsable en cas d'interruptions dues à des opérations de maintenance, des pannes techniques ou des événements de force majeure.</p>
        <div class="ml-alert">
          <span class="ml-alert-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          </span>
          <p>Les performances annoncées (latence, résolution, FPS) sont des valeurs indicatives pouvant varier selon la qualité de votre connexion internet et votre localisation géographique.</p>
        </div>
      </div>
    </div>

    <!-- 7. Contact légal -->
    <div class="ml-card" id="contact-legal">
      <div class="ml-card-head">
        <div class="ml-card-icon-wrap">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
        </div>
        <div>
          <span class="ml-card-num">07</span>
          <h2 class="ml-card-title">Contact légal</h2>
        </div>
      </div>
      <div class="ml-card-body">
        <p class="ml-text">Pour exercer vos droits ou toute question relative aux présentes mentions légales, contactez-nous :</p>
        <div class="ml-contact-grid">
          <div class="ml-contact-item">
            <div class="ml-contact-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            </div>
            <div class="ml-contact-label">E-mail général</div>
            <a href="mailto:contact@nebula.gg" class="ml-contact-val" style="color:var(--accent)">contact@nebula.gg</a>
          </div>
          <div class="ml-contact-item">
            <div class="ml-contact-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div class="ml-contact-label">DPO / RGPD</div>
            <a href="mailto:dpo@nebula.gg" class="ml-contact-val" style="color:var(--accent)">dpo@nebula.gg</a>
          </div>
          <div class="ml-contact-item">
            <div class="ml-contact-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div class="ml-contact-label">Courrier</div>
            <span class="ml-contact-val">1 rue des Étoiles<br>75001 Paris</span>
          </div>
        </div>
        <div class="ml-cta-row">
          <a href="/NEBULA/contact.php" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            Formulaire de contact
          </a>
          <a href="/NEBULA/faq.php" class="btn btn-outline">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Consulter la FAQ
          </a>
        </div>
      </div>
    </div>

  </main>
</div><!-- /.ml-wrap -->

</div><!-- /.ml-page -->

<?php require 'includes/footer.php'; ?>
