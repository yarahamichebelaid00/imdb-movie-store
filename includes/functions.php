<?php
//protege un texte avant l'afficher
function formatPrice($price)
{
    return number_format($price,2,',','').'€'
}
//affiche le bouton "ajouter au panier"
function showCartButton($movieId)
{
    echo '<form method="post" action="cart.php">';
    echo '<input type =hidden" name ="action" value="add">';
    echo '<input type =hidden" name="movie_id" value"' .(int) $movieId .'">';
    echo '<button type="submit" class="btn">Ajouter au panier</button>';
    echo' </form>'
}

//afiiche la carte d'un film
function showMovieCrd($movie){
    echo '<article class="card">';
    echo '<a href="movie_detail.php?id=' . $movie['id'] . '">';
    echo '<img scr=img/movies/>' . 
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