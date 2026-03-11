<?php
/**
 * À inclure en tête des pages réservées aux utilisateurs connectés.
 * Redirige vers auth.php si la session est absente.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: /NEBULA/auth.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}
