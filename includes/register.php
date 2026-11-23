<?php
// Import connexion à BDD
require_once '../config/pdo.php';
// Import fonctions sécurité et utilitaires
require_once 'csrf.php';
require_once 'helpers.php';

// Constantes
$error = "";
$success = "";

// Si formulaire bien envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Vérification token CSRF : appel fonction dans csrf.php
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

        // Vérification email => appel fonction dans helpers.php
        if (!isValidEmail($email)) {
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
                    $success = "Inscription réussie ! Vous pouvez vous connecter.";
                }
            }
        }
    }
}