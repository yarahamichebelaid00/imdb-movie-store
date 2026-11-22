<?php
// Fonctions authentification : savoir si user connecté.e à son compte, sinon renvoi vers login.php
// Démarrage session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fonction vérification si user connecté.e
function isLoggedIn() {
    // Vérification si ID du user est bien stocké dans la session ouverte
    return isset($_SESSION['user_id']);
}

// Fonction pour protèger les pages sensibles type Panier, Profil ou Commande
// Si user pas connecté.e à son compte, renvoi vers login.php
function requireLogin() {
    if (!isLoggedIn()) {
        // Message d'erreur pour user
        $_SESSION['error'] = "Vous devez être connecté.e pour accéder à cette page.";
        header("Location: login.php");
        exit(); // stoppe code ici car user pas authentifié.e => évite d'afficher ses données
    }
}