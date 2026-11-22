<nav class="main-nav">
    <a href="index.php">Accueil</a>
    <a href="category.php?id=1">Action</a>
    <a href="category.php?id=2">Drame</a>
    <?php if (isset($_SESSION['user'])): ?>
        <a href="cart.php">Panier</a>
        <a href="profile.php">Profil</a>
        <a href="logout.php">Déconexion</a>
    <?php else:?>
        <a href="login.php">Connexion</a>
        <a href="register.php">Inscription</a>
    <?php endif ; ?>
</nav>
