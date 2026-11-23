<?php
session_start();
require_once 'classes/movie.php';
require_once 'includes/functions.php';
include 'includes/header.php';

$movie=new Movie();
$movies=$movie-> getLatest();

?>

<main class="container">
    <h1>Bienvenue sur IMDb Store</h1>
    <p> Fini le papier ! Retrouvez toutes les informations sur vos films préférés,
    découvrez les dernières nouveautés et achetez vos films en quelques clics.</p>
<p>
    <a class="btn" href="category.php?id=1">Films d'action</a>
    <a class="btn" href="category.php?id=2">Drames</a>

</p>

    <h2>Derniers films ajoutés</h2>

    <?php
    echo '<div class="grid">';

    foreach($movies as $row){
    showMovieCard($row);
}

?>
</main>
<?php include 'includes/footer.php';?>
