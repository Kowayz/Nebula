<?php
$pageTitle = 'FAQ — Guide & Aide';
$pageCSS   = ['faq'];
$pageJS    = ['faq'];

$faqs = [
  ["Ai-je besoin d'un PC puissant ?", "Non. Nebula fonctionne sur n'importe quel appareil disposant d'une connexion internet : PC bas de gamme, Mac, smartphone, tablette ou Smart TV. Toute la puissance de calcul est sur nos serveurs."],
  ["Quelle connexion est recommandée ?", "Pour une expérience en HD (720p), 10 Mb/s suffisent. Pour du 4K à 144 FPS, nous recommandons 35 Mb/s minimum en fibre ou Ethernet."],
  ["Puis-je jouer avec ma manette ?", "Oui. Nebula est compatible avec toutes les manettes Bluetooth et USB : DualSense PlayStation, Xbox Series, Nintendo Switch Pro et claviers-souris."],
  ["Mes sauvegardes sont-elles conservées ?", "Vos sauvegardes cloud sont conservées 90 jours après la résiliation. En cas de réabonnement dans ce délai, vous retrouvez exactement votre progression."],
  ["Puis-je changer d'offre ?", "Oui, à tout moment depuis votre espace personnel. Les changements sont effectifs immédiatement avec ajustement au prorata."],
  ["Y a-t-il des frais cachés ?", "Aucun. Le prix affiché est tout inclus : aucun frais d'installation, de téléchargement, ou de DLC obligatoire."],
  ["Comment fonctionne le bouquet ?", "Le configurateur vous permet de sélectionner uniquement les genres et fonctionnalités qui vous intéressent. Vous payez exactement pour ce que vous utilisez."],
  ["Le service fonctionne-t-il en déplacement ?", "Oui, Nebula fonctionne depuis n'importe quel réseau — fibre, 4G/5G ou Wi-Fi public. Pour une qualité optimale nous recommandons une connexion stable et non partagée."],
  ["Quelle est la politique de remboursement ?", "Nous offrons un remboursement complet dans les 7 jours suivant le premier abonnement, sans condition. La demande se fait directement depuis votre espace personnel."],
];

require 'includes/header.php';
?>

<div class="faq-page">

<!-- ══════════════════════════ HERO ══════════════════════════ -->
<div class="faq-hero">
  <div class="faq-hero-orb faq-hero-orb-a"></div>
  <div class="faq-hero-orb faq-hero-orb-b"></div>
  <div class="faq-hero-orb faq-hero-orb-c"></div>
  <div class="faq-hero-inner">
    <div class="faq-hero-tag">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      Aide &amp; Support
    </div>
    <h1 class="faq-hero-title">Questions <span class="gradient-text">fréquentes</span></h1>
    <p class="faq-hero-sub">Tout ce que vous devez savoir sur Nebula, le cloud gaming et votre abonnement.</p>
  </div>
</div>

<!-- ══════════════════════════ QU'EST-CE QUE NEBULA ══════════════════════════ -->
<div class="faq-section faq-section--concept">
  <div class="faq-section-head">
    <div class="faq-section-tag">Concept</div>
    <h2 class="faq-section-title">Qu'est-ce que Nebula ?</h2>
    <p class="faq-section-sub">Une plateforme de cloud gaming — jouer sans télécharger, depuis n'importe quel appareil.</p>
  </div>
  <div class="what-grid">
    <div class="what-card">
      <div class="what-card-icon" style="background:linear-gradient(135deg,rgba(124,58,237,.4),rgba(159,18,57,.25))">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
      </div>
      <div class="what-card-title">Streaming haute performance</div>
      <div class="what-card-desc">Vos jeux tournent sur nos serveurs GPU et sont diffusés en direct sur votre écran, comme Netflix mais interactif. Moins de 20 ms de latence.</div>
    </div>
    <div class="what-card">
      <div class="what-card-icon" style="background:linear-gradient(135deg,rgba(244,114,182,.35),rgba(124,58,237,.25))">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
      </div>
      <div class="what-card-title">Tous vos appareils</div>
      <div class="what-card-desc">PC, Mac, Smart TV, smartphone, tablette. Reprenez votre partie là où vous l'avez laissée, sur l'appareil de votre choix.</div>
    </div>
    <div class="what-card">
      <div class="what-card-icon" style="background:linear-gradient(135deg,rgba(34,197,94,.3),rgba(124,58,237,.25))">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      </div>
      <div class="what-card-title">Sans engagement</div>
      <div class="what-card-desc">Aucun téléchargement, aucun matériel coûteux, aucun engagement. Abonnez-vous et commencez à jouer en quelques secondes.</div>
    </div>
  </div>
</div>

<!-- ══════════════════════════ COMMENT ÇA MARCHE ══════════════════════════ -->
<div class="faq-section-dark faq-section--steps">
  <div class="faq-section-head">
    <div class="faq-section-tag">Démarrage</div>
    <h2 class="faq-section-title">Comment ça marche ?</h2>
    <p class="faq-section-sub">En 4 étapes, passez de nouveau joueur à gamer cloud en moins de 5 minutes.</p>
  </div>
  <div class="steps-grid">
    <div class="step-card">
      <div class="step-top">
        <div class="step-num">01</div>
        <div class="step-connector"></div>
      </div>
      <div class="step-icon-wrap">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
      </div>
      <div class="step-title">Créer un compte</div>
      <div class="step-desc">Inscrivez-vous en 60 secondes avec votre adresse e-mail. Aucune carte bancaire requise pour l'offre Starter.</div>
    </div>
    <div class="step-card">
      <div class="step-top">
        <div class="step-num">02</div>
        <div class="step-connector"></div>
      </div>
      <div class="step-icon-wrap">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><path d="M9 8h6M12 6v4"/></svg>
      </div>
      <div class="step-title">Choisir un jeu</div>
      <div class="step-desc">Parcourez notre catalogue de +200 titres. Filtrez par genre, nouveautés ou popularité.</div>
    </div>
    <div class="step-card">
      <div class="step-top">
        <div class="step-num">03</div>
        <div class="step-connector"></div>
      </div>
      <div class="step-icon-wrap">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
      </div>
      <div class="step-title">Appuyer sur Jouer</div>
      <div class="step-desc">Le jeu démarre en quelques secondes directement dans votre navigateur. Aucun téléchargement.</div>
    </div>
    <div class="step-card">
      <div class="step-top">
        <div class="step-num">04</div>
      </div>
      <div class="step-icon-wrap">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
      </div>
      <div class="step-title">Sauvegardes auto</div>
      <div class="step-desc">Votre progression est sauvegardée automatiquement dans le cloud. Reprenez sur n'importe quel appareil.</div>
    </div>
  </div>
</div>

<!-- ══════════════════════════ POURQUOI NEBULA ══════════════════════════ -->
<div class="faq-section faq-section--benefits">
  <div class="faq-section-head">
    <div class="faq-section-tag">Avantages</div>
    <h2 class="faq-section-title">Pourquoi choisir Nebula ?</h2>
    <p class="faq-section-sub">Ce qui nous distingue des autres services de cloud gaming.</p>
  </div>
  <div class="benefits-grid">
    <div class="benefit-item">
      <div class="benefit-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
      <div class="benefit-body"><div class="benefit-title">Latence &lt; 20 ms</div><div class="benefit-desc">Inférieure à la plupart des concurrents. Idéal pour les jeux compétitifs.</div></div>
    </div>
    <div class="benefit-item">
      <div class="benefit-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg></div>
      <div class="benefit-body"><div class="benefit-title">4K · 144 FPS</div><div class="benefit-desc">Ultra HD avec HDR10 et ray tracing sur tous vos jeux inclus.</div></div>
    </div>
    <div class="benefit-item">
      <div class="benefit-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
      <div class="benefit-body"><div class="benefit-title">Sauvegardes cloud</div><div class="benefit-desc">Synchronisation automatique et conservation 90 jours après résiliation.</div></div>
    </div>
    <div class="benefit-item">
      <div class="benefit-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
      <div class="benefit-body"><div class="benefit-title">Sans engagement</div><div class="benefit-desc">Résiliation en un clic depuis votre espace. Remboursement garanti 7 jours.</div></div>
    </div>
    <div class="benefit-item">
      <div class="benefit-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg></div>
      <div class="benefit-body"><div class="benefit-title">Multi-appareils</div><div class="benefit-desc">PC, Mac, TV, smartphone — reprenez exactement là où vous étiez.</div></div>
    </div>
    <div class="benefit-item">
      <div class="benefit-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><path d="M9 8h6M12 6v4"/></svg></div>
      <div class="benefit-body"><div class="benefit-title">+200 jeux AAA</div><div class="benefit-desc">Catalogue mis à jour chaque semaine avec les dernières sorties.</div></div>
    </div>
  </div>
</div>

<!-- ══════════════════════════ FAQ ACCORDION ══════════════════════════ -->
<div class="faq-section-dark faq-section--faq">
  <div class="faq-section-head">
    <div class="faq-section-tag">FAQ</div>
    <h2 class="faq-section-title">Questions fréquentes</h2>
    <p class="faq-section-sub">Les réponses aux questions les plus posées par notre communauté.</p>
  </div>

  <div class="faq-list">
    <?php foreach ($faqs as $i => $f): ?>
    <div class="faq-item">
      <button class="faq-question" type="button">
        <span class="faq-q-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
        <span class="faq-q-text"><?= htmlspecialchars($f[0]) ?></span>
        <svg class="faq-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
      </button>
      <div class="faq-answer-wrap">
        <div class="faq-answer"><p><?= htmlspecialchars($f[1]) ?></p></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="faq-not-found">
    Vous ne trouvez pas votre réponse ?
    <a href="/NEBULA/contact.php" style="color:var(--accent);text-decoration:underline">Contactez notre équipe</a>
  </div>
</div>

<!-- ══════════════════════════ CTA ══════════════════════════ -->
<div class="faq-cta">
  <div class="faq-cta-glow"></div>
  <div class="faq-cta-inner">
    <div class="faq-cta-tag">Prêt à jouer ?</div>
    <h2 class="faq-cta-title">Commencez gratuitement</h2>
    <p class="faq-cta-sub">Rejoignez des milliers de joueurs. Aucune carte bancaire pour démarrer.</p>
    <div class="faq-cta-btns">
      <a href="/NEBULA/auth.php?tab=register" class="btn btn-primary btn-lg">Créer un compte gratuit</a>
      <a href="/NEBULA/offres.php" class="btn btn-outline btn-lg">Voir les offres</a>
    </div>
  </div>
</div>

</div><!-- /.faq-page -->

<?php require 'includes/footer.php'; ?>
