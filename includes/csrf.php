<?php
// CSRF = attaque pour forcer le web browser à faire une action à l'insue du user
// Solution = poser sur chaque page un mot de passe ou jeton secret = token

// Démarrage de la session pour stocker le token
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fonction pour générer et stocker un token unique
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Fonction pour vérifier si token envoyé est bon => fonction appelée dans register.php
function verifyCsrfToken($token) {
    // Si token envoyé correspond pas à celui de la session => attaque !
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        die("Erreur de sécurité : Jeton CSRF invalide.");
    }
}

// Génération token directement à l'ouverture de la page
generateCsrfToken();