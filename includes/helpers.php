<?php
// Fichier de fonctions utilitaires

// Fonction vérification si email valide
function isValidEmail($email) {
    // filter_var vérifie si format email = correct
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Fonction hash du mot de passe => pas stockés en clair
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Fonction vérification mot de passe lors de la connexion : recalcul et comparaison du hash
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Fonction "nettoyage" des données envoyées par formulaire
// pour éviter attaques XSS (injection de code dans pages)
function cleanInput($data) {
    $data = trim($data); // Enlève espaces au début et à la fin des données
    $data = stripslashes($data); // Enlève les anti-slashs
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Transforme les caractères spéciaux
    return $data;
}