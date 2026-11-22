<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Import fichier de configuration pour connexion à la BDD
require_once '/home/Cat/projects-Supinfo/imdb-movie-store/config/pdo.php';

// Si test_pdo.php s'exécute, alors fichier pdo.php a été exécuté (pas de die, catch) = connexion réussie
echo "Connexion réussie !<br>";
echo "Connexion à la base de données : " . DB_NAME . "<br>";

// Test : demande nombre d'acteurs pour vérifier bonne lecture de la BDD
try {
    //$stmt = statement => pas de requête préparée, code en dur car requête pas à modifier
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM actors");
    $result = $stmt->fetch();
    echo "Nombre d'acteurs dans la BDD : " . $result['count'];
} 
catch (PDOException $e) {
    echo "Erreur lors de la requête : " . $e->getMessage();
}
?>