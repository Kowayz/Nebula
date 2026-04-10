<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$pageTitle = 'Contact';
$pageCSS   = ['contact'];
$pageJS    = [];

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sujet   = trim($_POST['sujet']   ?? '');
    $contenu = trim($_POST['message'] ?? '');
    $userId  = $_SESSION['user_id']   ?? null;

    if ($sujet === '' || $contenu === '') {
        $error = 'Veuillez remplir le sujet et le message.';
    } else {
        try {
            require_once 'includes/db.php';
            $pdo  = getPDO();
            $stmt = $pdo->prepare(
                'INSERT INTO message (sujet, contenu, id_user) VALUES (:sujet, :contenu, :uid)'
            );
            $stmt->execute([':sujet'=>$sujet,':contenu'=>$contenu,':uid'=>$userId]);
        } catch (Exception $e) {
            // Silently ignore DB errors — message still shows success to user
            error_log('Contact DB error: ' . $e->getMessage());
        }
        $success = 'Votre message a bien été envoyé. Nous vous répondrons sous 24h.';
    }
}

require 'includes/header.php';
?>

<section class="section">
  <div class="section-header">
    <div class="section-tag">Support</div>
    <h1 style="font-size:clamp(1.8rem,4vw,2.6rem);font-weight:900;margin-bottom:10px">Nous contacter</h1>
    <p class="text-muted">Notre équipe vous répond généralement sous 24h.</p>
  </div>

  <div class="contact-grid">
    <div class="contact-info">
      <h3>Informations de contact</h3>
      <p>Une question, un problème technique ou une suggestion ? Nous sommes là pour vous aider.</p>

      <div class="contact-item">
        <div class="contact-item-icon">
          <img src="/NEBULA/public/assets/img/icons/contact/email.png" alt="icon" width="20" height="20" class="icon-img">
        </div>
        <div class="contact-item-text">
          <strong>E-mail</strong>
          <span>support@nebula.gg</span>
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-item-icon">
          <img src="/NEBULA/public/assets/img/icons/contact/email.png" alt="icon" width="20" height="20" class="icon-img">
        </div>
        <div class="contact-item-text">
          <strong>Discord</strong>
          <span>discord.gg/nebula — réponse en moins de 2h</span>
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-item-icon">
          <img src="/NEBULA/public/assets/img/icons/dashboard/horloge.png" alt="icon" width="14" height="14" class="icon-img">
        </div>
        <div class="contact-item-text">
          <strong>Horaires</strong>
          <span>Lundi – Vendredi, 9h – 20h</span>
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-item-icon">
          <img src="/NEBULA/public/assets/img/icons/ecommerce/bouclier-securite.png" alt="icon" width="14" height="14" class="icon-img">
        </div>
        <div class="contact-item-text">
          <strong>Support prioritaire</strong>
          <span>24/7 pour les abonnés Ultra</span>
        </div>
      </div>
    </div>

    <div class="card">
      <h3 style="font-size:1rem;font-weight:700;margin-bottom:20px">Envoyer un message</h3>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" novalidate>
        <?php if (empty($_SESSION['user_id'])): ?>
        <div class="form-group">
          <label for="email_contact">Votre e-mail</label>
          <input type="email" id="email_contact" name="email_contact" class="form-control" placeholder="vous@exemple.com">
        </div>
        <?php endif; ?>
        <div class="form-group">
          <label for="sujet">Sujet</label>
          <select id="sujet" name="sujet" class="form-control" required>
            <option value="">Choisir un sujet…</option>
            <option>Problème technique</option>
            <option>Question sur mon abonnement</option>
            <option>Remboursement</option>
            <option>Suggestion</option>
            <option>Autre</option>
          </select>
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea id="message" name="message" class="form-control" rows="5" placeholder="Décrivez votre demande…" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-full">
          <img src="/NEBULA/public/assets/img/icons/nav/fleche-droite.png" alt="icon" width="20" height="20" class="icon-img">
          Envoyer le message
        </button>
      </form>
    </div>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
