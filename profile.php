<?php
session_start();
require_once 'classes/movie.php';
require_once 'classes/user.php';
require_once 'includes/functions.php';
include 'includes/header.php';
?>

<main class="container">
    <h1>Mon Profil</h1>
    <?php
// si personne n'est connecté ,on demande de se connecter
if (!isset($_SESSION[])){
    echo '<p class="message"Vous devez être connecté(e) pour voir votre profil.<a href="login.php">Se connecter</a></p>';

} else{
    $userId = $_SESSION['user']['id'];
    $error = '';
    $success='';

// changement du mot de passe quand le formulaire est envoyé

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = $POST['old_password'] ?? '';
    $newPassword = $POST['new_password'] ?? '';
    $confirmPassword = $POST['confirm_password'] ?? '';

    $user = new User();
    $userDetails = $user->getById($userId);

    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error ='Erreur de sécurité.Veuillez recharger la page.';
    }elseif (!password_verify($oldPassword, $userDetails['password'])) {
        $error = 'L\'ancien mot de passe est incorrect';
    }elseif ($newPassword ! == $confirmPassword){
        $error = 'Les nouveaux mots de passe ne correspondent pas.';
    } else{
        $user->updatePassword($userId, password_hash($newPassword,PASSWORD_DEFAULT));
        $success = 'Votre mot passe a été modifié';
    }
}
echo '<p>Bonjour ' . htmlentities($_SESSION['user']['username']) . ' !</p>';


//liste des films achetés
echo '<h2> Mes film achetés</h2>';
$movie = new Movie();
$movies =$movie->getPurchasedByUser($userId);

if (empty($movies)){
    echo '<p class="message"> Vous n\'avez encore acheté acun film.</p>';
}else{
    echo '<ul>';
    foreach ($movies as $row){
        echo '<li><a href="movie_detail.php?id=' .(int)$row['id']. '">' . htmlspecialchars($row['title']) . '</a></li>';
    }
    echo '</ul>';
}

// formulaire pour changer le mot passe
echo '<h2>Changer mon mot de passe </h2>';
if ($error! == ''){
    echo '<p class="messsage">' . htmlspecialchars($success) . '</p>';
}

echo '<form method="post" action ="profile.php">';
displayCsrfToken();
echo '<label for="old password">Ancien mot de passe</label>';
echo '<input type="password" id="old_password"  name="old_password" required>';
echo '<label for="new_password" id="new_password">Nouveau mot passe</label>';
echo '<input type="password" id="new_password" name="new_password" required>';
echo '<label for="confirm_password">Confirmer le nouveau mot de passe</label>';
echo '<input type="password" id="confirm_password" name="confirm_password" required';
echo '<input type="submit" value="Modifier">';
echo '</form>';


echo '<p><a class="btn" href="logout.php">Se déconnecter</a></p>';
}
?>
</main>

<?php include 'includes/footer.php'; ?>