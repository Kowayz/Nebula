<?php
/* ============================================================
   PANIER.PHP — Page du panier d'achats
   Gère l'ajout, la suppression et le vidage du panier via
   les paramètres GET (?add=, ?remove=, ?vider=).
   Les articles sont stockés en BDD (table "panier") et liés
   à l'utilisateur connecté via son user_id en session.
   ============================================================ */

// -- Connexion BDD et démarrage de la session --
require 'includes/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$pdo = getPDO();

// -- Configuration de la page --
$pageTitle = 'Panier';
$pageCSS   = ['panier'];
$pageJS    = [];

// -- Récupérer l'ID utilisateur depuis la session --
$userId = $_SESSION['user_id'] ?? 0;

// -- ACTION : AJOUTER un article au panier (?add=ID&nom=...&prix=...) --
if (isset($_GET['add'])) {
    // Vérifier que l'utilisateur est connecté
    if (empty($_SESSION['user_id'])) {
        header('Location: /NEBULA/auth.php?tab=login&redirect=panier.php');
        exit;
    }
    
    // Récupérer les infos de l'article depuis l'URL
    $idRef = (int)$_GET['add'];
    $nom   = $_GET['nom'] ?? 'Article';
    $prix  = (float)($_GET['prix'] ?? 0);
    $cat   = $_GET['cat'] ?? 'jeu';
    $type  = ($cat === 'boutique') ? 'produit' : $cat; // boutique → produit
    
    // Vérifier si l'article existe déjà dans le panier
    $stmt = $pdo->prepare('SELECT id_panier, quantite, type FROM panier WHERE id_ref = ? AND id_user = ? AND type = ?');
    $stmt->execute([$idRef, $userId, $type]);
    $exist = $stmt->fetch();
    
    if ($exist) {
        // Produit boutique : augmenter la quantité (+1)
        if ($exist['type'] === 'produit') {
            $stmt = $pdo->prepare('UPDATE panier SET quantite = quantite + 1 WHERE id_panier = ?');
            $stmt->execute([$exist['id_panier']]);
        }
        // Offre / jeu : ne pas dupliquer
    } else {
        $stmt = $pdo->prepare('INSERT INTO panier (id_user, type, id_ref, nom, prix, quantite) VALUES (?, ?, ?, ?, ?, 1)');
        $stmt->execute([$userId, $type, $idRef, $nom, $prix]);
    }
    header('Location: panier.php');
    exit;
}

// -- ACTION : SUPPRIMER un article du panier (?remove=ID) --
if (isset($_GET['remove'])) {
    if (empty($_SESSION['user_id'])) {
        header('Location: /NEBULA/auth.php?tab=login');
        exit;
    }
    $idPanier = (int)$_GET['remove'];
    $stmt = $pdo->prepare('DELETE FROM panier WHERE id_panier = ? AND id_user = ?');
    $stmt->execute([$idPanier, $userId]);
    header('Location: panier.php');
    exit;
}

// -- ACTION : VIDER tout le panier (?vider=1) --
if (isset($_GET['vider'])) {
    if (empty($_SESSION['user_id'])) {
        header('Location: /NEBULA/auth.php?tab=login');
        exit;
    }
    $stmt = $pdo->prepare('DELETE FROM panier WHERE id_user = ?');
    $stmt->execute([$userId]);
    header('Location: panier.php');
    exit;
}

// -- PAYER via Stripe Checkout --
// Quand l'utilisateur clique sur "Payer avec Stripe", on :
//   1. Lit la clé secrète Stripe depuis .env.local
//   2. Calcule le total TTC du panier
//   3. Envoie une requête cURL à l'API Stripe pour créer une "session Checkout"
//   4. Redirige l'utilisateur vers la page de paiement hébergée par Stripe
// Stripe gère tout le formulaire de carte bancaire de son côté.
// En mode test, on utilise la carte fictive 4242 4242 4242 4242.
if (isset($_GET['payer']) && !empty($_SESSION['user_id'])) {

    // Lire le fichier .env.local pour récupérer STRIPE_SECRET_KEY
    // (même méthode que pour les clés IGDB dans api/igdb.php)
    $envPath = __DIR__ . '/.env.local';
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos($line, '=') && $line[0] !== '#') {
            [$k, $v] = explode('=', $line, 2);
            $env[trim($k)] = trim($v);
        }
    }

    // Récupérer les articles du panier et calculer le total
    $stmt = $pdo->prepare('SELECT prix, quantite FROM panier WHERE id_user = ?');
    $stmt->execute([$userId]);
    $items = $stmt->fetchAll();
    $total = 0;
    foreach ($items as $i) $total += $i['prix'] * $i['quantite'];

    // Convertir en centimes TTC (Stripe attend des centimes, pas des euros)
    // Exemple : 29.99€ HT × 1.20 (TVA 20%) = 35.988€ TTC = 3599 centimes
    $totalCents = (int)round($total * 1.20 * 100);

    // Appel cURL vers l'API Stripe pour créer la session de paiement
    // Documentation : https://docs.stripe.com/api/checkout/sessions/create
    $ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Récupérer la réponse au lieu de l'afficher
    curl_setopt($ch, CURLOPT_POST, true);             // Requête POST
    curl_setopt($ch, CURLOPT_USERPWD, $env['STRIPE_SECRET_KEY'] . ':'); // Authentification HTTP Basic
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'payment_method_types' => ['card'],                    // Paiement par carte uniquement
        'line_items' => [[                                     // Un seul article : le total de la commande
            'price_data' => [
                'currency' => 'eur',                           // Devise : euros
                'product_data' => ['name' => 'Commande Nebula'], // Nom affiché sur la page Stripe
                'unit_amount' => $totalCents,                  // Montant en centimes
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',                                   // Paiement unique (pas abonnement)
        'success_url' => 'http://localhost/NEBULA/panier.php?paid=1', // Redirection si paiement OK
        'cancel_url'  => 'http://localhost/NEBULA/panier.php',        // Redirection si annulé
    ]));
    $session = json_decode(curl_exec($ch), true);  // Décoder la réponse JSON de Stripe
    curl_close($ch);

    // Stripe renvoie une URL de paiement → on redirige l'utilisateur dessus
    if (!empty($session['url'])) {
        header('Location: ' . $session['url']);
        exit;
    }
}

// -- ACTION : Retour après paiement réussi (?paid=1) --
// Stripe redirige ici après un paiement validé → on vide le panier
if (isset($_GET['paid']) && !empty($_SESSION['user_id'])) {
    $stmt = $pdo->prepare('DELETE FROM panier WHERE id_user = ?');
    $stmt->execute([$userId]);
    $paymentSuccess = true;
}

// -- Récupérer les articles du panier depuis la BDD (si connecté) --
if (!empty($_SESSION['user_id'])) {
    $stmt = $pdo->prepare('SELECT * FROM panier WHERE id_user = ? ORDER BY date_ajout DESC');
    $stmt->execute([$userId]);
    $panier = $stmt->fetchAll();
} else {
    $panier = [];
}

// -- Calculs des totaux (sous-total, TVA 20%, total TTC) --
$sousTotal = 0;
foreach ($panier as $item) {
    $sousTotal += $item['prix'] * $item['quantite'];
}
$tva = $sousTotal * 0.20;
$total = $sousTotal + $tva;

// -- Inclure le header commun --
require 'includes/header.php';
?>

<!-- ── Hero du panier ── -->
<section class='section text-center cart-hero'>
  <div class='section-tag'>Panier</div>
  <h1>Votre <span class='gradient-text'>panier</span></h1>
</section>

<section class='section'>

<!-- État 1 : Utilisateur non connecté → message + boutons login/register -->
<?php if (empty($_SESSION['user_id'])): ?>
  <div class='cart-empty'>
    <div class='cart-empty-icon'><img src='/NEBULA/public/assets/img/icons/ecommerce/padlock.png' alt='Connexion' width='64' height='64'></div>
    <h2 class='cart-empty-title'>Connexion requise</h2>
    <p class='cart-empty-sub'>Connectez-vous pour accéder à votre panier et effectuer des achats.</p>
    <div class='cart-empty-actions'>
      <a href='/NEBULA/auth.php?tab=login' class='btn btn-primary'>Se connecter</a>
      <a href='/NEBULA/auth.php?tab=register' class='btn btn-outline'>Créer un compte</a>
    </div>
  </div>

<!-- État 2a : Paiement réussi → message de confirmation -->
<?php elseif (!empty($paymentSuccess)): ?>
  <div class='cart-empty'>
    <div class='cart-empty-icon'><img src='/NEBULA/public/assets/img/icons/ecommerce/coche-incluse.png' alt='Succès' width='64' height='64'></div>
    <h2 class='cart-empty-title'>Paiement réussi !</h2>
    <p class='cart-empty-sub'>Merci pour votre achat. Votre commande a bien été enregistrée.</p>
    <div class='cart-empty-actions'>
      <a href='/NEBULA/jeux.php' class='btn btn-primary'>Parcourir les jeux</a>
      <a href='/NEBULA/dashboard.php' class='btn btn-outline'>Mon espace</a>
    </div>
  </div>

<!-- État 2b : Panier vide → message + liens vers boutique/jeux -->
<?php elseif (empty($panier)): ?>
  <div class='cart-empty'>
    <div class='cart-empty-icon'><img src='/NEBULA/public/assets/img/icons/ecommerce/cadille.png' alt='Panier vide' width='64' height='64'></div>
    <h2 class='cart-empty-title'>Votre panier est vide</h2>
    <p class='cart-empty-sub'>Découvrez nos jeux et commencez à remplir votre panier.</p>
    <div class='cart-empty-actions'>
      <a href='/NEBULA/boutique.php' class='btn btn-primary'>Voir la boutique</a>
      <a href='/NEBULA/jeux.php' class='btn btn-outline'>Parcourir les jeux</a>
    </div>
  </div>

<!-- État 3 : Panier avec articles → liste + résumé des prix -->
<?php else: ?>
  <div class='cart-layout'>
    <!-- Liste des articles du panier -->
    <div class='cart-items'>
      <?php foreach ($panier as $item): ?>
        <div class='cart-item'>
          <div class='cart-item-info'>
            <h4 class='cart-item-name'><?= htmlspecialchars($item['nom']) ?></h4>
            <p class='cart-item-price'><?= number_format($item['prix'], 2) ?> €</p>
          </div>
          <div class='cart-item-actions'>
            <!-- Afficher la quantité si > 1 (produits boutique) -->
            <?php if ($item['type'] === 'produit' && $item['quantite'] > 1): ?>
              <span>x<?= $item['quantite'] ?></span>
            <?php endif; ?>
            <p class='cart-item-total'><?= number_format($item['prix'] * $item['quantite'], 2) ?> €</p>
            <a href='?remove=<?= $item['id_panier'] ?>' class='cart-remove' title='Supprimer'>
              <img src='/NEBULA/public/assets/img/icons/ecommerce/poubelle.png' alt='Supprimer' width='18' height='18'>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    
    <!-- Résumé : sous-total, TVA, total et bouton payer (vide le panier) -->
    <div class='cart-summary'>
      <p>Sous-total: <?= number_format($sousTotal, 2) ?> €</p>
      <p>TVA (20%): <?= number_format($tva, 2) ?> €</p>
      <p><strong>Total: <?= number_format($total, 2) ?> €</strong></p>
      <a href='panier.php?payer=1' class='btn btn-primary'>Payer avec Stripe</a>
    </div>
  </div>
<?php endif; ?>

</section>

<?php require 'includes/footer.php'; ?>
