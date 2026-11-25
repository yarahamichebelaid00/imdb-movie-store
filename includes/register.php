<?php
// Fichier fonction = formulaire de création de compte

// Import connexion à BDD
require_once '../config/pdo.php';
// Import fonctions sécurité et utilitaires
require_once 'csrf.php';
require_once 'helpers.php';

// Démarrage session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = "";
$success = '';

// Si formulaire de création de compte bien envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Vérification token CSRF => appel fonction dans csrf.php
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) { 
    // Au cas où token a expiré ou si double envoi du formulaire :
        $error = "Erreur de sécurité. Veuillez recharger la page.";
    }
    else {
        // Récupération et nettoyage des données => appel fonction dans helpers.php
        $email = cleanInput($_POST['email']);
        $username = cleanInput($_POST['username']);
        $password = $_POST['password']; // pas de nettoyage pour mot de passe
        $passwordConfirm = $_POST['password_confirm']; // idem

        // Vérification que champs = pas vides
        if (empty($email) || empty($username) || empty($password) || empty($passwordConfirm)) {
            $error = 'Veuillez remplir tous les champs.';
        }

        // Vérification email => appel fonction dans helpers.php
        elseif (!isValidEmail($email)) {
            $error = "L'email n'est pas valide.";
        }

        // Vérification correspondance mots de passe entre les 2 champs
        elseif ($password !== $passwordConfirm) {
            $error = "Les mots de passe ne correspondent pas.";
        }
        
        // Vérification si email pas déjà utilisé => requête BDD
        else {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email"); // envoi modèle requête
            $stmt->execute(['email' => $email]); // envoi valeurs de la requête
            if ($stmt->fetch()) {
                $error = "Cet email est déjà utilisé.";
            }
            
            // Vérification si username pas déjà utilisé
            else {
                $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
                $stmt->execute(['username' => $username]);
                if ($stmt->fetch()) {
                    $error = "Ce nom d'utilisateur.rice est déjà pris.";
                }
            
                // Si email et username pas déjà utilisés, inscription user
                else {
                    // Hashage du mot de passe => appel fonction dans helpers.php
                    $hashedPassword = hashPassword($password);

                    // Insertion dans BDD (modèle avec :placeholders pour éviter injection SQL dans champs)
                    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
                    $stmt->execute([
                        'username' => $username,
                        'email' => $email,
                        'password' => $hashedPassword
                    ]);

                    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                    // Vider les champs du formulaire
                    $email = '';
                    $username = '';
                    $password = '';
                    $passwordConfirm = '';
                }
            }
        }
    }
}
?>
<!-- --- Partie HTML : Affichage du formulaire Créer un compte --- -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <h1>Créer un compte</h1>
    
    <!-- Affichage messages d'erreurs ou de succès -->
    <?php if ($error): ?> <!-- tests OK -->
        <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?php echo htmlspecialchars($success); ?></p>
        <p><a href="../login.php">Aller à la page de connexion</a></p>
    <?php endif; ?>

    <form method="POST" action="">
    
    <!-- Inclusion token CSRF dans session => appel fonction dans csrf.php -->
    <?php displayCsrfToken(); ?>
    
    <label for="username">Nom d'utilisateur.rice :</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email :</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="password_confirm">Confirmer le mot de passe :</label><br>
        <input type="password" id="password_confirm" name="password_confirm" required><br><br>

        <button type="submit">S'inscrire</button>
    </form>
    
    <p>Déjà inscrit.e ? <a href="../login.php">Se connecter</a></p>
    <p>Déconnexion temporaire <a href="../logout.php">Se déconnecter</a></p>
    <?php include 'includes/footer.php';?>
</body>
</html>