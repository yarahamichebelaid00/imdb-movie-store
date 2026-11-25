<?php
// Fichier fonction = formulaire de connexion à son compte + vérification ID

// Import fonctions connexion, sécurité et utilitaires
require_once 'includes/db.php';    // Connexion à BDD (via fonction $pdo)
require_once 'includes/csrf.php';
require_once 'includes/functions.php';

// Démarrage session (obligatoire pour utiliser $_SESSION)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['error'])) { 
   $error = $_SESSION['error']; 
   unset($_SESSION['error']); 
}

$pdo = getDbConnection();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification token CSRF en 1er
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = 'Erreur de sécurité. Veuillez recharger la page et réessayer.';
    }
    
    else {
        $email = cleanInput($_POST['email'] ?? ''); // nettoyage données => appel fonction dans helpers.php
        $password = $_POST['password'] ?? ''; // Pas de nettoyage pour mot de passe

        // Vérification que champs = pas vides
        if (empty($email) || empty($password)) {
            $error = 'Veuillez remplir tous les champs.';
        }

        // Vérification dans BDD
        if (empty($error)) {

            // Requête préparée => pour chercher match user par email
            $stmt = $pdo->prepare('SELECT id, email, password, username FROM users WHERE email = :email');
            $stmt->execute([':email' => $email]);
            // Récupération de la 1ère et unique ligne de résultats pour l'email qui matche (stockage ds variable $user)
            $user = $stmt->fetch();

    
            if ($user && password_verify($password, $user['password'])) {
                // Alors connexion réussie
                // Stockage infos du user dans la session
                $_SESSION['user'] = $user['id'];

                $success = "Connexion réussie ! Bienvenue " . htmlspecialchars($user['username'])." !"; 

            }
            else {
                $error = 'Email ou mot de passe invalide.';
            }
        }
    }
} ?>
<!--- Partie HTML : Affichage du formulaire Se connecter  -->
<?php include 'includes/header.php'; ?>
    <h1>Se connecter</h1>
    
    <!-- Si attaque, script transformé en caractères HTML = non exécutable -->
    <!-- Affichage messages d'erreurs ou de succès => tests OK  -->
    <?php if ($error): ?>
        <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?php echo htmlspecialchars($success); ?></p>
        <p><a href="index.php">Aller à la page d'accueil</a></p>
    <?php endif; ?>
    
    <form method="POST" action="login.php">
        
        <!-- Inclusion token CSRF dans session => appel fonction dans csrf.php -->
        <?php displayCsrfToken(); ?>
        
        <label for="email">Email :</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Se connecter</button>
    </form>

    <p>Pas encore inscrit.e ? <a href="register.php">Créer un compte</a></p>
    <p>Déconnexion temporaire <a href="logout.php">Se déconnecter</a></p>
<?php include 'includes/footer.php';?>