/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.20-13.0.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: movie_db
-- ------------------------------------------------------
-- Server version	13.0.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Current Database: `movie_db`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `movie_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `movie_db`;

--
-- Table structure for table `actors`
--

DROP TABLE IF EXISTS `actors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `actors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_actor_name` (`last_name`,`first_name`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actors`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `actors` WRITE;
/*!40000 ALTER TABLE `actors` DISABLE KEYS */;
INSERT INTO `actors` VALUES
(20,'Mahershala','Ali'),
(21,'Jonathan','Bailey'),
(3,'Ramzy','Bedia'),
(51,'Zazie','Beetz'),
(48,'Haley','Bennett'),
(23,'Jack','Black'),
(10,'Emily','Blunt'),
(52,'Marlon','Brando'),
(24,'Adrien','Brody'),
(12,'Josh','Brolin'),
(38,'Asa','Butterfield'),
(54,'James','Caan'),
(44,'Mario','Casas'),
(5,'Jesús','Castro'),
(42,'Sam','Claflin'),
(41,'Emilia','Clarke'),
(35,'François','Cluzet'),
(50,'Robert','De Niro'),
(11,'Benicio','Del Toro'),
(34,'Laura','Dern'),
(31,'Leonardo','DiCaprio'),
(2,'Nicolas','Duvauchelle'),
(55,'Clint','Eastwood'),
(33,'Ansel','Elgort'),
(26,'Mireille','Enos'),
(40,'Vera','Farmiga'),
(47,'Rebecca','Ferguson'),
(30,'Jeff','Gum'),
(57,'Ahney','Her'),
(14,'Theo','James'),
(19,'Scarlett','Johansson'),
(27,'Daniella','Kertesz'),
(37,'Anne','Le Ny'),
(46,'Bárbara','Lennie'),
(1,'Alban','Lenoir'),
(6,'Sergi','López'),
(43,'Janet','McTeer'),
(53,'Al','Pacino'),
(49,'Joaquin','Phoenix'),
(25,'Brad','Pitt'),
(7,'Keanu','Reeves'),
(17,'Zoe','Saldaña'),
(39,'Jack','Scanlon'),
(29,'Johnathon','Schaech'),
(9,'Bill','Skarsgård'),
(28,'Sophie','Skelton'),
(36,'Omar','Sy'),
(4,'Luis','Tosar'),
(56,'Bee','Vang'),
(45,'Ana','Wagener'),
(22,'Naomi','Watts'),
(18,'Sigourney','Weaver'),
(15,'Kate','Winslet'),
(13,'Shailene','Woodley'),
(16,'Sam','Worthington'),
(8,'Donnie','Yen'),
(32,'Billy','Zane');
/*!40000 ALTER TABLE `actors` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `added_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'Action'),
(2,'Drame');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `directors`
--

DROP TABLE IF EXISTS `directors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `directors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_director_name` (`last_name`,`first_name`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directors`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `directors` WRITE;
/*!40000 ALTER TABLE `directors` DISABLE KEYS */;
INSERT INTO `directors` VALUES
(25,'Josh','Boone'),
(8,'Neil','Burger'),
(9,'James','Cameron'),
(34,'Clint','Eastwood'),
(10,'Gareth','Edwards'),
(33,'Francis','Ford Coppola'),
(12,'Marc','Forster'),
(28,'Mark','Herman'),
(13,'Hèctor','Hernández Vicens'),
(11,'Peter','Jackson'),
(5,'Daniel','Monzón'),
(26,'Olivier','Nakache'),
(30,'Oriol','Paulo'),
(32,'Todd','Phillips'),
(4,'Guillaume','Pierret'),
(29,'Thea','Sharrock'),
(6,'Chad','Stahelski'),
(31,'Tate','Taylor'),
(27,'Éric','Toledano'),
(7,'Denis','Villeneuve');
/*!40000 ALTER TABLE `directors` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(6,2) NOT NULL,
  `release_date` date DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` VALUES
(1,'Titanic','À bord du Titanic, Jack et Rose vivent une histoire d\"amour pendant le voyage tragique du paquebot.',19.99,'1997-11-01','titanic.jpg',2,'2026-11-20 19:55:58'),
(2,'Nos étoiles contraires','Deux adolescents atteints d\"un cancer tombent amoureux et partent ensemble à Amsterdam.',14.99,'2014-05-16','nos-etoiles-contraires.jpg',2,'2026-11-20 22:26:53'),
(3,'Intouchables','Un riche aristocrate tétraplégique engage comme aide à domicile un jeune homme de banlieue.',19.99,'2011-10-04','intouchables.jpg',2,'2026-11-20 22:29:36'),
(4,'Le Garçon au pyjama rayé','Pendant la Seconde Guerre mondiale, le fils d\"un officier nazi se lie d\"amitié avec un garçon de l\"autre côté d\"une clôture.',15.99,'2008-09-12','le-garcon-au-pyjama-raye.jpg',2,'2026-11-20 22:40:29'),
(5,'Avant toi','Une jeune femme devient l\"aide-soignante d\"un homme paralysé après un accident et leurs vies changent.',19.99,'2016-06-03','avant-toi.jpg',2,'2026-11-20 22:43:45'),
(6,'L\"Accusé','Un homme d\"affaires accusé de meurtre a quelques heures avec son avocate pour prouver son innocence.',19.99,'2016-09-23','l-accuse.jpg',2,'2026-11-20 22:48:39'),
(7,'La Fille du train','Chaque jour dans son train, Rachel observe un couple, jusqu\"au jour où la femme disparaît.',19.99,'2016-10-07','la-fille-du-train.jpg',2,'2026-11-20 22:51:27'),
(8,'Joker','À Gotham, Arthur Fleck, un comique raté, bascule peu à peu dans la folie.',19.99,'2019-08-31','joker.jpg',2,'2026-11-20 22:54:47'),
(9,'Le Parrain','L\"histoire de la famille Corleone, l\"une des plus puissantes familles de la mafia new-yorkaise.',5.99,'1972-03-15','le-parrain.jpg',2,'2026-11-20 23:02:22'),
(10,'Gran Torino','Un vétéran de la guerre de Corée, bougon et solitaire, se lie d\"amitié avec ses jeunes voisins.',9.99,'2008-12-17','gran-torino.jpg',2,'2026-11-20 23:04:48'),
(11,'Balle perdue','Lino, un mécanicien de génie, est accusé d\"un meurtre qu\"il n\"a pas commis et doit retrouver la seule preuve de son innocence : une balle perdue.',19.99,'2020-06-19','balle-perdue.jpg',1,'2026-11-20 23:07:48'),
(12,'El Niño','Dans le détroit de Gibraltar, un jeune pilote de bateau se lance dans le trafic de drogue, traqué par deux policiers.',15.99,'2014-08-29','el-nino.jpg',1,'2026-11-20 23:10:22'),
(13,'John Wick : Chapitre 4','John Wick affronte la Grande Table à travers le monde pour gagner enfin sa liberté.',19.99,'2023-03-22','john-wick-4.jpg',1,'2026-11-20 23:12:46'),
(14,'Sicario','Une agente du FBI est recrutée pour une mission secrète contre un cartel à la frontière mexicaine.',15.99,'2015-09-18','sicario.jpg',1,'2026-11-20 23:15:19'),
(15,'Divergente','Dans un Chicago futuriste divisé en factions, une jeune fille découvre qu\"elle est « divergente » et donc menacée.',12.99,'2014-03-21','divergente.jpg',1,'2026-11-20 23:17:48'),
(16,'Avatar','Sur la planète Pandora, un ancien marin se retrouve au cœur du conflit entre les humains et le peuple Na\"vi.',19.99,'2009-12-10','avatar.jpg',1,'2026-11-20 23:20:22'),
(17,'Jurassic World : Renaissance','Une équipe part sur une île interdite pour prélever l\"ADN de dinosaures géants.',19.99,'2025-07-02','jurassic-world-renaissance.jpg',1,'2026-11-20 23:22:52'),
(18,'King Kong','Une équipe de tournage découvre sur une île mystérieuse un gorille géant qui sera ramené à New York.',9.99,'2005-12-05','king-kong.jpg',1,'2026-11-20 23:25:28'),
(19,'World War Z','Un ancien enquêteur de l\"ONU parcourt le monde pour stopper une pandémie qui transforme les humains en zombies.',15.99,'2013-06-21','world-war-z.jpg',1,'2026-11-20 23:27:43'),
(20,'Day of the Dead: Bloodline','Dans un bunker militaire, une jeune médecin cherche un remède alors que les zombies ont envahi le monde.',14.99,'2017-06-21','day-of-the-dead-bloodline.jpg',1,'2026-11-20 23:30:14');
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `movies_actors`
--

DROP TABLE IF EXISTS `movies_actors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `movies_actors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_movie_actor` (`movie_id`,`actor_id`),
  KEY `actor_id` (`actor_id`),
  CONSTRAINT `1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `2` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies_actors`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `movies_actors` WRITE;
/*!40000 ALTER TABLE `movies_actors` DISABLE KEYS */;
INSERT INTO `movies_actors` VALUES
(2,1,15),
(1,1,31),
(3,1,32),
(4,2,13),
(5,2,33),
(6,2,34),
(7,3,35),
(8,3,36),
(9,3,37),
(10,4,38),
(11,4,39),
(12,4,40),
(13,5,41),
(14,5,42),
(15,5,43),
(16,6,44),
(17,6,45),
(18,6,46),
(19,7,10),
(20,7,47),
(21,7,48),
(22,8,49),
(23,8,50),
(24,8,51),
(25,9,52),
(26,9,53),
(27,9,54),
(28,10,55),
(29,10,56),
(30,10,57),
(31,11,1),
(32,11,2),
(33,11,3),
(34,12,4),
(35,12,5),
(36,12,6),
(37,13,7),
(38,13,8),
(39,13,9),
(40,14,10),
(41,14,11),
(42,14,12),
(43,15,13),
(44,15,14),
(45,15,15),
(46,16,16),
(47,16,17),
(48,16,18),
(49,17,19),
(50,17,20),
(51,17,21),
(52,18,22),
(53,18,23),
(54,18,24),
(55,19,25),
(56,19,26),
(57,19,27),
(58,20,28),
(59,20,29),
(60,20,30);
/*!40000 ALTER TABLE `movies_actors` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `movies_directors`
--

DROP TABLE IF EXISTS `movies_directors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `movies_directors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_id` int(11) NOT NULL,
  `director_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_movie_director` (`movie_id`,`director_id`),
  KEY `director_id` (`director_id`),
  CONSTRAINT `1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `2` FOREIGN KEY (`director_id`) REFERENCES `directors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies_directors`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `movies_directors` WRITE;
/*!40000 ALTER TABLE `movies_directors` DISABLE KEYS */;
INSERT INTO `movies_directors` VALUES
(1,1,9),
(2,2,25),
(3,3,26),
(4,4,28),
(5,5,29),
(6,6,30),
(7,7,31),
(8,8,32),
(9,9,33),
(10,10,34),
(11,11,4),
(12,12,5),
(13,13,6),
(14,14,7),
(15,15,8),
(16,16,9),
(17,17,10),
(18,18,11),
(19,19,12),
(20,20,13);
/*!40000 ALTER TABLE `movies_directors` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `price_at_purchase` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_amount` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-11-21  0:05:43
