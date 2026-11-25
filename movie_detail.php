<?php
session_start();
require_once 'classes/movie.php';
require_once 'includes/functions.php';
$title ='Détail du film- IMBd';
include 'includes/header.php';

?>

<main class="container">
    <?php

    $movie = new Movie();
    $movieDetails=false;

    if (isset($_GET['id'])) {
        $movieDetails = $movie->getById($_GET['id']);
    }
    if(!$movieDetails){
        echo '<h1>Film introuvable</h1>';
        echo '<p class="message">Ce film n\'existe pas . <a href ="index.php"> Retour a l\'accueil </a></p>';
    } else {
        $directors = $movie-> getDirectors($movieDetails['id']);
        $actors = $movie->getActors($movieDetails['id']);

        echo '<article class= "movie-detail">';
        echo '<img src="img/movies/'  . htmlspecialchars($movieDetails['image_url']) . '" alt="'. htmlspecialchars($movieDetails['title']) . '">';
        echo '<div>';
        echo '<h1>' . htmlspecialchars($movieDetails['title']) . '</h1>';

    // substr() garde les premieres caractères de la date par example 10-12-1999 devient 1998
       echo'<p>' . substr($movieDetails['release_date'],0,4) . ' . realise par ';

       //un lien par réalisateur, séparés par <et> par example le film intouchables en a deux 

       foreach($directors as $i=>$director){
        if ($i> 0){
            echo ' et ';
        }
        echo '<a href="director.php?id=' . $director['id'] . '">' . htmlspecialchars($director['first_name'] . ' ' . $director['last_name']) . '</a>';
        }

        echo '</p>';
        echo '<p>' . htmlspecialchars($movieDetails['description']) . '</p>';

        echo '<h2>Acteurs</h2>';
        echo '<ul>';

        foreach ($actors as $actor) {
            echo '<li>' . htmlspecialchars ($actor ['first_name'] . ' ' . $actor['last_name'] ) . '</li>';
            }

        echo '</ul>';
        echo '<span class="price">' . formatPrice($movieDetails['price']) . '</span>';
        showCartButton($movieDetails['id']);
        echo '</div>';
        echo '</article>';
        }

        ?>
        </main>
        <?php include 'includes/footer.php'; ?>


            