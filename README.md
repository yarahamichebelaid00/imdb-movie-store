# imdb-movie-store
Projet PHP

1. Description du projet
Ce projet a été réalisé dans le cadre d'un cours de développement web centré sur le PHP. L'objectif est de créer une plateforme en ligne permettant aux utilisateurs de :

1-Consulter un catalogue de films (Accueil, Catégories Action et Drame, détails du film lorsqu'on clique dessus => movie_detail.php).
2-Rechercher des films par titre ou par réalisateur.
3-Créer un compte, s'y connecter et gérer leur profil (changement de mot de passe).
4-Ajouter des films à un panier persistant.
5-Valider une commande ("checkout") et consulter leur historique d'achat.

Le site est développé en PHP avec une base de données MariaDB/MySQL, utilisant le serveur Apache côté Linux.

2. Auteurs
Yara Hamiche Belaid : Développement Front-end (HTML, CSS, Intégration) et Back-end (Logique PHP).
Mélanie Harlé: Développement Back-end (Base de données, Logique PHP, Sécurité).

3. Prérequis techniques
Pour faire tourner ce projet en local, vous avez besoin de :
OS : Linux (Arch Linux utilisé), Windows ou macOS.
Serveur Web : Apache (httpd).
Langage : PHP (version 8.0 recommandée) avec les extensions pdo_mysql.
Base de données : MariaDB ou MySQL.
Navigateur : Chrome, Firefox, Edge...

4. Installation & Configuration

Suivez ces étapes pour installer le projet localement, quel que soit votre système d'exploitation (Windows, Mac ou Linux).

Prérequis : Un serveur web local (Apache + PHP + MySQL/MariaDB). Si vous n'en avez pas, XAMPP (Windows/Mac) ou MAMP (Mac).

Étape 1 : Clôner le projet
Exemple sur un terminal Linux :
git clone https://github.com/yarahamichebelaid00/imdb-movie-store.git

Étape 2 : Placer le projet dans le serveur web
Sous XAMPP (Windows/Mac) : Déplacez le dossier imdb-movie-store dans le dossier htdocs.
Sous WAMP (Windows) : Déplacez-le dans le dossier www.
Sous Linux (Arch) : Créez un lien symbolique : sudo ln -s ~/projects-Supinfo/imdb-movie-store /srv/http/

Étape 3 : Configurer la base de données
Ouvrez phpMyAdmin (généralement http://localhost/phpmyadmin).
Créez une base nommée movie_db.
Importez le fichier SQL fourni :
    Allez dans l'onglet Importer.
    Sélectionnez le fichier database/movie_db.sql présent dans le projet.

Étape 4 : Configurer les accès PHP (Sécurité)
Le fichier de connexion contient des mots de passe sensibles. Vous devez le créer manuellement.
Allez dans le dossier includes/.
Copiez le fichier modèle : cp includes/db.example.php includes/db.php (ou faites une copie manuelle sous Windows/Mac).
Ouvrez includes/db.php et modifiez les identifiants pour qu'ils correspondent à votre configuration locale.

Étape 5 : Lancement
Ouvrez votre navigateur et allez sur l'URL locale correspondante (ex: http://localhost/imdb-movie-store).

5. Structure du projet

imdb-movie-store/
├── classes/        
│   ├── category.php     
│   ├── director.php     
│   ├── movie.php       
│   └── user.php  
├── css/                    # Mise en page CSS
│   └── style.css
├── database/               # Fichiers SQL (Dump structure + données)
├── img/movies/             # Images des fiches films
│   └── img/movies
├── includes/               # Code logique partagé
│   ├── auth.php            # Gestion sessions & redirection login
│   ├── csrf.php            # Protection CSRF
│   ├── db.example.php      # Modèle connexion PDO
│   ├── db.php              # Connexion PDO (GITIGNORED)
│   ├── functions.php       # Fonctions utilitaires et de sécurité
│   ├── menu.php            # Menu commun
│   ├── header.php          # En-tête HTML commun
│   └── footer.php          # Pied de page HTML commun

├── index.php        # Page d'accueil
├── category.php     # Page Catégories Action et Drame
├── director.php     # Page Réalisateur.rice
├── cart.php         # Panier
├── checkout.php     # Commande
├── profile.php      # Espace utilisateur.rice
├── search.php       # Moteur de recherche
├── register.php     # Création de compte
├── login.php        # Connexion au compte
└── logout.php       # Déconnexion

6. Schéma de la Base de Données
La base de données relationnelle est composée des tables suivantes :

Table	            Rôle
movies	            Contient les infos principales (Titre, Prix, Image, Description).
directors	        Liste des réalisateur.rices.
actors	            Liste des acteurs.
categories	        Types de films (Action, Drame).
users	            Comptes clients (Email, Mot de passe hashé).
cart	            Panier temporaire lié à un utilisateur.
orders	            Historique des commandes validées.
order_items	        Détail des articles achetés dans chaque commande.
movies_directors	Table de jointure (Un film peut avoir plusieurs réalisateur.rices).
movies_actors	    Table de jointure (Un film a plusieurs acteur.rices).

7. Fonctionnalités & Sécurité
Le code a été écrit en appliquant les principes suivants :

Injection SQL :
Les requêtes utilisent des requêtes préparées PDO (prepare / execute). Aucune concaténation de variables dans le SQL.

Mots de passe :
Hachage sécurisé via password_hash() et vérification via password_verify().

Protection XSS :
Toutes les données affichées dans le HTML sont nettoyées avec htmlspecialchars().

Attaques CSRF :
Les formulaires critiques (Login, Register, Checkout, Add to Cart) incluent un jeton CSRF vérifié côté serveur.