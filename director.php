<?php
session_start();
require_once 'classes/director.php';
require_once 'classes/movie.php';
require_once 'includes/functions.php';
include 'includes/header.php';
?>

<main class="container">
    <?php
    $director =new Director();
    $directorDetails=false;

//on cherche le réalisateur grçace à l'id dans l'url : par example :director.php?id=9 pour james cameron.
    if (isset($_GET['id'])){
        $directorDetails=$director->getById($_GET['id']);
    }

    if (!$directorDetails){
        echo '<h1>Réalisateur introuvable</h1>';
        echo '<p class="message">Ce réalisateur n\'existe pas . <a href="index.php">Retour à l\'accueil</a></p>';
    } else{
        $movie =new Movie();
        $movies =$movie->getByDirector($directorDetails['id']);

        echo '<h1>' . htmlspecialchars($directorDetails['first_name'] . ' ' . $directorDetails['last_name']) . '</h1>';
        echo '<h2>  Ses films (' . count($movies) . ')</h2>';


        echo '<div class="grid">'; 

        foreach ($movies as $row){
            showMovieCard($row);
        }

        echo'</div>';
    }
    ?>
</main>
<?php include 'includes/footer.php'; ?>
