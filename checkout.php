<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$userId = $_SESSION['user'];
$pdo = getDbConnection();
$message = '';
$done =false;

//se bloc d'exécute seulement quand onn clique sur le bouton "confirmer l'achat"
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

if (!verifyCsrfToken($_POST['csrf_token'] ?? '')){
       $message = 'Erreur de sécurité.Veuillez réessayer';
 
} else {
//on recupere les film du panier et leur prix depuis la base de données
$stmt =$pdo->prepare("SELECT movies.id,movies.price FROM cart JOIN movies ON movies.id =cart.movie_id WHERE cart.user_id = :user_id");
$stmt ->bindParam(':user_id',$userId);
$stmt-> execute();
$items =$stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($items)){
    $message = 'Votre panier est vide';

} else{
//calculer le total
    $total = 0;
    foreach ($items as $item){
        $total += $item['price'];
    }

//on cree la commnde
    $stmt =$pdo-> prepare ("INSERT INTO orders (user_id, order_date,total_amount)VALUES (:user_id,NOW(),:total)");
    $stmt->bindParam(':user_id,$userId');
    $stmt->execute();
    $orderId =$pdo->lastInsertId();

//on ajoute chaque film dans la commande 
foreach ($items as $item) {
    $stmt =$pdo-> prepare("INSERT INTO order_items (order_id,movie_id,price_at_purchase)VALUES (:order_id,:movie_id,:price)");
    $stmt->bindParam(':order_id',$orderId);
    $stmt->bindParam (':movie_id',$item ['id']);
    $stmt->bindParam(':price',$item['price']);
    $stmt->execute();

}

//vider lepanier
$stmt =$pdo->prepare("DELETE FROM cart WHERE user_id =:user_id");
$stmt->bindParam (':user_id' ,$userId);
$stmt->bindParam(':total',$total);
$stmt->execute();

$message ='Merci! Votre achat est validé.Vos films sont dans votre profil.';
$done=true;


}
}
}
$title='Validation de l\'achat -IMDd Store';
include 'includes/header.php';
?>

<main class="container">
    <h1>Validation de l'achat</h1>
    <?php
    if($message !== ''){
        echo '<p class="message">' . htmlspecialchars($message) . '</p>';

    }
    
    if ($done){
        echo '<a class="btn" href="profile.php">Voir mes films</a>';


    }else{
        echo '<p>Voulez vous confirmer l\'achat des films de votre panier ?</p>';
        echo '<form method="post" action="checkout.php">';
        displayCsrfToken();
        echo '<input type="submit" value="Confirmer l\'achat">';
        echo '</form>';
        echo '<p><a href="cart.php">Retour au panier </a></p>';

    }
    ?>
    </main>
    <?php include 'includes/footer.php'; ?>