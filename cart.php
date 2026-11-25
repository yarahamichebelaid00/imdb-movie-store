<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

// --- DEBUG ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("POST action: " . ($_POST['action'] ?? 'NOT SET'));
    error_log("POST movie_id type: " . gettype($_POST['movie_id'] ?? 'NOT SET'));
    error_log("POST movie_id value: ");
    var_dump($_POST['movie_id'] ?? null);
    error_log("SESSION user type: " . gettype($_SESSION['user'] ?? 'NOT SET'));
    error_log("SESSION user value: ");
    var_dump($_SESSION['user'] ?? null);
}
// --- FIN DEBUG ---

requireLogin();

$user_id = $_SESSION['user'];
$pdo = getDbConnection();

// --- AJOUT FILM AU PANIER => POST ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {

    // Vérification token CSRF envoyé par formulaire
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Session expirée ; veuillez réessayer.');
    }

    // Nettoyage ID => s'assurer que c'est bien un nombre
    $movie_id = (int) ($_POST['movie_id'] ?? 0);

    // Vérification film existe dans BDD
    $stmt = $pdo->prepare("SELECT id FROM movies WHERE id = :id");
    $stmt->execute([':id' => $movie_id]);
    $movie = $stmt->fetch();

    if ($movie) {
        // Vérification film pas déjà dans panier
        $stmt = $pdo->prepare("SELECT id FROM cart WHERE user_id = :uid AND movie_id = :mid");
        $stmt->execute([':uid' => $user_id, ':mid' => $movie_id]);

        // Si ok, insertion du nouveau film
        if (!$stmt->fetch()) {
            $stmt = $pdo->prepare("INSERT INTO cart (user_id, movie_id) VALUES (:uid, :mid)");
            $stmt->execute([':uid' => $user_id, ':mid' => $movie_id]);
            $_SESSION['cart_message'] = "Film ajouté au panier !";
        }
        else {
            $_SESSION['cart_message'] = "Ce film est déjà dans votre panier.";
        }
    }
    else {
        $_SESSION['cart_message'] = "Film introuvable.";
    }

    // Redirection même page pour éviter réajout du film
    header('Location: cart.php');
    exit();
}

// --- Suppression d'un film du panier => GET ---
if (isset($_GET['remove'])) {
    $remove_id = (int) $_GET['remove'];
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :uid AND id = :cid");
    $stmt->execute([':uid' => $user_id, ':cid' => $remove_id]);
    header('Location: cart.php');
    exit();
}

// --- Vider le panier => GET ---
if (isset($_GET['empty'])) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :uid");
    $stmt->execute([':uid' => $user_id]);
    header('Location: cart.php');
    exit();
}

// --- Requête affichage cart => GROUP BY pour éviter doublon de ligne/prix sur film avec >1 director
$stmt = $pdo->prepare("
    SELECT 
        c.id AS cart_id,
        m.id AS movie_id,
        m.title,
        m.price,
        m.image_url,
        GROUP_CONCAT(CONCAT(d.first_name, ' ', d.last_name) 
        ORDER BY d.last_name SEPARATOR ', ') AS director_names
    FROM cart c
    JOIN movies m ON c.movie_id = m.id
    LEFT JOIN movies_directors md ON md.movie_id = m.id
    LEFT JOIN directors d ON d.id = md.director_id
    WHERE c.user_id = :uid
    GROUP BY c.id, m.id, m.title, m.price, m.image_url
    ORDER BY c.id DESC
");
$stmt->execute([':uid' => $user_id]);
$cart_items = $stmt->fetchAll();

// Calcul du total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'];
}
// Arrondi à 2 décimales pour éviter problèmes de virgule flottante ??? :_)
$total = round($total, 2);
?>

<!-- Partie HTML : Affichage du formulaire Panier -->
<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Votre Panier</h1>

    <?php if (isset($_SESSION['cart_message'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_SESSION['cart_message']); ?>
        </div>
        <?php unset($_SESSION['cart_message']); ?>
    <?php endif; ?>

    <!-- Cas où le panier est vide -->
    <?php if (empty($cart_items)): ?>
        <p>Votre panier est vide.</p>
        <a href="index.php" class="btn">Retour à l'accueil</a>
    <?php else: ?>

    <!-- Tableau du panier -->
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Titre</th>
                <th>Directeur</th>
                <th>Prix</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td>
                        <img src="img/movies/<?php echo htmlspecialchars($item['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($item['title']); ?>" width="50">
                    </td>
                    <td>
                        <a href="movie_detail.php?id=<?php echo $item['movie_id']; ?>">
                        <?php echo htmlspecialchars($item['title']); ?> </a>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($item['director_names'] ?? 'N/A'); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars(formatPrice($item['price'])); ?>
                    </td>
                    <td>
                        <a href="cart.php?remove=<?php echo $item['cart_id']; ?>" class="btn btn-danger">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Total et bouton vider -->
    <div class="cart-summary">
        <h3>Total : <?php echo htmlspecialchars(formatPrice($total)); ?></h3>
        <a href="cart.php?empty=1" class="btn btn-danger" 
        onclick="return confirm('Voulez-vous vraiment vider votre panier ?')">Vider le panier</a>
        <a href="checkout.php" class="btn btn-success">Passer à la caisse</a> <!---à faire ensuite ?--->
    </div>
<?php endif; ?>
</div>

<?php include 'includes/footer.php';?>