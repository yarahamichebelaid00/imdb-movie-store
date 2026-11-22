<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMDb Store</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="logo" href="index.php">IMDb Store</a>
            <?php include 'icludes/menu.php'; ?>
// la recherche envoiee le texte à search.php 

<form class="search-form" method="get" action="search.php">
  <input type="text" name="q" placeholder="titre" required>
       <input type="submit" class="btn"  value="recherhcer">
           </form>
        </div>
    </header>
