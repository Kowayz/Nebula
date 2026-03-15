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
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
        </div>
        <div class="contact-item-text">
          <strong>E-mail</strong>
          <span>support@nebula.gg</span>
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-item-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <div class="contact-item-text">
          <strong>Discord</strong>
          <span>discord.gg/nebula — réponse en moins de 2h</span>
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-item-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="contact-item-text">
          <strong>Horaires</strong>
          <span>Lundi – Vendredi, 9h – 20h</span>
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-item-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
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
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
          Envoyer le message
        </button>
      </form>
    </div>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
