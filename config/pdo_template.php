<?php
// fichier modèle => ne jamais l'utiliser tel quel pour la production
// rôle du fichier = paramètes génériques pour copie dans un autre fichier

// Définition des paramètres de connexion (constantes)
define('DB_HOST', 'localhost');   // = serveur MySQL sur PC local
define('DB_NAME', 'movie_db');    // = nom BDD
define('DB_CHARSET', 'utf8mb4');  // pour caractères français + emojis
define('DB_USER', 'imdb_user');   // = nom du user local de la BDD
?>