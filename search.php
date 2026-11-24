<?php
session_start();
require_once 'classes/movie.php';
require_once 'includes/functions.php';
include 'includes/header.php';

?>

<main class="container">
    <h1>Recherche</h1>
    <?php
//on récupere le mot cherché par l'utilisateur par example: si la personne tape CAMERON, l'url devient search.php?search=cameron
$text ='';

if (isset($_GET['search'])){
    $text=trim($_GET['search']);
}

if ($text === ''){
    echo '<p class="message">Tapez un titre de film ou nom de réalisateur.</p>'; 

} else {
    $movie=new Movie();
    $movies =$movie->search($text);

    if(empty($movies)){
        echo '<p class="message">Acun film trouvé pour " ' . htmlspecialchars($text) .  ' "</p>';
    } else {
        echo '<p>' . count($movies) . ' resultat(s) pour " ' .  htmlspecialchars($text) . ' "</p>';
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