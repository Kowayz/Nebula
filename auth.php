<?php
require 'includes/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: /NEBULA/dashboard.php');
    exit;
}

$tab            = $_GET['tab'] ?? 'login';
$loginError     = '';
$registerError  = '';

/* ── Traitement login ──────────────────────────────────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
    $tab      = 'login';
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $loginError = 'Veuillez remplir tous les champs.';
    } else {
        $pdo  = getPDO();
        $stmt = $pdo->prepare('SELECT id_user, nom, password, role FROM utilisateur WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']   = $user['id_user'];
            $_SESSION['user_nom']  = $user['nom'];
            $_SESSION['user_role'] = $user['role'];

            $redirect = $_GET['redirect'] ?? '/NEBULA/dashboard.php';
            header('Location: ' . $redirect);
            exit;
        } else {
            $loginError = 'E-mail ou mot de passe incorrect.';
        }
    }
}

/* ── Traitement register ───────────────────────────────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'register') {
    $tab      = 'register';
    $nom      = trim($_POST['nom']              ?? '');
    $email    = trim($_POST['email']            ?? '');
    $password = trim($_POST['password']         ?? '');
    $confirm  = trim($_POST['password_confirm'] ?? '');

    if ($nom === '' || $email === '' || $password === '' || $confirm === '') {
        $registerError = 'Veuillez remplir tous les champs.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $registerError = 'Adresse e-mail invalide.';
    } elseif (strlen($password) < 8) {
        $registerError = 'Le mot de passe doit contenir au moins 8 caractères.';
    } elseif ($password !== $confirm) {
        $registerError = 'Les mots de passe ne correspondent pas.';
    } else {
        $pdo = getPDO();
        $chk = $pdo->prepare('SELECT id_user FROM utilisateur WHERE email = :email');
        $chk->execute([':email' => $email]);
        if ($chk->fetch()) {
            $registerError = 'Cette adresse e-mail est déjà utilisée.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins  = $pdo->prepare(
                'INSERT INTO utilisateur (email, password, nom, role) VALUES (:email, :password, :nom, :role)'
            );
            $ins->execute([':email' => $email, ':password' => $hash, ':nom' => $nom, ':role' => 'client']);
            $stmt = $pdo->prepare('SELECT id_user, nom, role FROM utilisateur WHERE email = :email LIMIT 1');
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();
            session_regenerate_id(true);
            $_SESSION['user_id']   = $user['id_user'];
            $_SESSION['user_nom']  = $user['nom'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: /NEBULA/dashboard.php');
            exit;
        }
    }
}

$pageTitle = 'Connexion';
$pageCSS   = ['auth'];
$pageJS    = ['auth'];
require 'includes/header.php';
?>

<div class="auth-wrapper">
  <div class="auth-card" data-initial-tab="<?= $tab ?>">

    <!-- ── Login panel ─────────────────────────────────────── -->
    <div class="auth-panel" id="panel-login">
      <p class="auth-subtitle">Content de vous revoir !</p>

      <?php if ($loginError): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($loginError) ?></div>
      <?php endif; ?>

      <form method="POST" action="" id="loginForm" novalidate>
        <input type="hidden" name="action" value="login">

        <div class="form-group">
          <label for="login-email">E-mail</label>
          <div class="input-wrapper">
            <span class="input-icon">
              <img src="/NEBULA/public/assets/img/icons/contact/email.png" alt="icon" width="20" height="20" class="icon-img">
            </span>
            <input type="email" id="login-email" name="email" class="form-control"
                   placeholder="vous@exemple.com" required autocomplete="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="login-password">Mot de passe</label>
          <div class="input-wrapper">
            <span class="input-icon">
              <img src="/NEBULA/public/assets/img/icons/contact/document-legal.png" alt="icon" width="22" height="22" class="icon-img">
            </span>
            <input type="password" id="login-password" name="password" class="form-control"
                   placeholder="••••••••" required autocomplete="current-password">
            <button type="button" class="input-toggle" aria-label="Afficher le mot de passe">
              <img src="/NEBULA/public/assets/img/icons/nav/oeil-ouvert.png" alt="icon" width="20" height="20" class="icon-img">
            </button>
          </div>
          <a href="#" class="form-link">Mot de passe oublié ?</a>
          <div class="clearfix"></div>
        </div>

        <button type="submit" class="btn btn-primary btn-full mt-8">Se connecter</button>
      </form>

      <div class="auth-footer">
        Pas encore de compte ?
        <a href="#" data-switch-tab="register">Créer un compte</a>
      </div>
    </div>

    <!-- ── Register panel ─────────────────────────────────── -->
    <div class="auth-panel" id="panel-register">
      <p class="auth-subtitle">Commencez gratuitement, sans carte bancaire.</p>

      <?php if ($registerError): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($registerError) ?></div>
      <?php endif; ?>

      <form method="POST" action="" id="registerForm" novalidate>
        <input type="hidden" name="action" value="register">

        <div class="form-group">
          <label for="reg-nom">Nom complet</label>
          <div class="input-wrapper">
            <span class="input-icon">
              <img src="/NEBULA/public/assets/img/icons/nav/fleche-droite.png" alt="icon" width="20" height="20" class="icon-img">
            </span>
            <input type="text" id="reg-nom" name="nom" class="form-control"
                   placeholder="Votre prénom et nom" required
                   value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="reg-email">E-mail</label>
          <div class="input-wrapper">
            <span class="input-icon">
              <img src="/NEBULA/public/assets/img/icons/contact/email.png" alt="icon" width="20" height="20" class="icon-img">
            </span>
            <input type="email" id="reg-email" name="email" class="form-control"
                   placeholder="vous@exemple.com" required autocomplete="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="reg-password">Mot de passe</label>
          <div class="input-wrapper">
            <span class="input-icon">
              <img src="/NEBULA/public/assets/img/icons/contact/document-legal.png" alt="icon" width="22" height="22" class="icon-img">
            </span>
            <input type="password" id="reg-password" name="password" class="form-control"
                   placeholder="8 caractères minimum" required autocomplete="new-password">
            <button type="button" class="input-toggle" aria-label="Afficher le mot de passe">
              <img src="/NEBULA/public/assets/img/icons/nav/oeil-ouvert.png" alt="icon" width="20" height="20" class="icon-img">
            </button>
          </div>
        </div>

        <div class="form-group">
          <label for="reg-password-confirm">Confirmer le mot de passe</label>
          <div class="input-wrapper">
            <span class="input-icon">
              <img src="/NEBULA/public/assets/img/icons/contact/document-legal.png" alt="icon" width="22" height="22" class="icon-img">
            </span>
            <input type="password" id="reg-password-confirm" name="password_confirm" class="form-control"
                   placeholder="Répétez le mot de passe" required autocomplete="new-password">
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-full mt-8">Créer mon compte</button>
      </form>

      <div class="auth-footer">
        Déjà un compte ?
        <a href="#" data-switch-tab="login">Se connecter</a>
      </div>
    </div>

  </div>
</div>

<?php require 'includes/footer.php'; ?>
