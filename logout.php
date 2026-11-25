<?php
// Fichier fonction = déconnexion du compte => destruction session

// Désigner la session démarrée (obligatoire pour utiliser $_SESSION)
session_start();

// Suppression de toutes les variables de session en une fois
$_SESSION = [];

// Destruction de la session (cookie de session supprimé)
session_destroy();

// Redirection vers page d'accueil
header('Location: index.php');

exit;
?>