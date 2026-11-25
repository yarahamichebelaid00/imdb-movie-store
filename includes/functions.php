<?php
// Fichier de fonctions utilitaires
require_once __DIR__ . '/csrf.php';

//affiche unprix au format français : par example 9.99 devient 9.99 €
function formatPrice($price) 
{
    return number_format($price,2,',',' ') . ' €';
}
//affiche le bouton "ajouter au panier"
function showCartButton($movieId)
{
    echo '<form method="post" action="cart.php">';
    echo '<input type ="hidden" name ="action" value="add">';
    echo '<input type ="hidden" name="movie_id" value="' .(int) $movieId .'">';
    displayCsrfToken();
    echo '<button type="submit" class="btn">Ajouter au panier</button>';
    echo' </form>';
}

//afiiche la carte d'un film
function showMovieCard($movie){
    echo '<article class="card">';
    echo '<a href="movie_detail.php?id=' . $movie['id'] . '">';
    echo '<img src="img/movies/' . 
htmlspecialchars($movie['image_url']) . '" alt="' . 
htmlspecialchars($movie['title']) . '">';
    echo '</a>';
    echo '<div class="card-body">';
    echo '<h3> <a href="movie_detail.php?id=' . $movie['id']. '">' . 
htmlspecialchars($movie ['title']) .'</a></h3>';
    echo '<span class="price">' . formatPrice($movie['price']).
'</span>';
      showCartButton($movie['id']) ;
      echo '</div>';
      echo '</article>';
}

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