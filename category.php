<?php
session_start();
require_once 'classes/category.php';
require_once 'classes/movie.php';
require_once 'includes/functions.php';
$title ='Catégorie -IMBd Store';
include 'includes/header.php';

?>

<main class="container">
     <?php

//on cheche la  categorie grace a l'id dans l'url de category.php?id=1


$category=new category();
$categoryDetails=false;

if(isset($_GET['id'])){
    $categoryDetails= $category->getById($_GET['id']);
}

if (!$categoryDetails){
    echo '<h1>Categorie introuvable</h1>';
    echo '<p class="message">Cette catégorie n\'existe pas.<a href="index.php">Retour à l\'accueil</a></p>';
} else {
    $movie=new movie();
    $movies=$movie-> getByCategory($categoryDetails['id']);

    echo '<h1>' . htmlspecialchars($categoryDetails['name']) . '</h1>';


    if (empty($movies)){
        echo '<p class="message">Acun film dans cette catégorie pour le moment.</p>';
    } else {
        echo '<div class="grid">';

        foreach($movies as $row){
            showMovieCard($row);
        }
        echo '</div>';
    }
}

?>
</main>
<?php include 'includes/footer.php'; ?>