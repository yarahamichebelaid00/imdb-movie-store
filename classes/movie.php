<?php
require_once __DIR__ . '/../includes/db.php';

class Movie {
    private $pdo;

    public function __construct()
{
    $this->pdo = getDbConnection();
}
// 8 derniers films ajoutée
public function getLatest (){
    $stmt=$this->pdo->prepare("SELECT * FROM movies ORDER BY created_at DESC LIMIT 8");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getById($id){
    $stmt=$this->pdo->prepare("SELECT * FROM movies WHERE id=:id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getByCategory($categoryId){
    $stmt=$this->pdo->prepare("SELECT * FROM movies WHERE category_id=:category_id ORDER BY title ASC");
    $stmt->bindParam(':category_id',$categoryId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//la table relie les films et les réalisateurs 
public function getByDirector($directorId){
    $stmt=$this->pdo->prepare("SELECT movies.*FROM movies JOIN movies_directors ON movies.id= movies_directors.movie_id WHERE movies_directors.director_id=:director_id ORDER BY movies.release_date DESC");

    $stmt->bindParam(':director_id',$directorId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//un film peut avoir plusiers réalisateurs (comme le  film:Intouchables)
public function getDirectors($movieId){
   $stmt=$this->pdo->prepare("SELECT directors.* FROM directors JOIN movies_directors ON directors.id= movies_directors.movie_id WHERE movies_directors.movie_id=:movie_id ");
   $stmt->bindParam(':movie_id',$movieId);
   $stmt->execute();

   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getActors($movieId){
 $stmt=$this->pdo->prepare("SELECT actors.*FROM actors JOIN movies_actors ON actors.id= movies_actors.actor_id WHERE movies_actors.movie_id=:movie_id");
 $stmt->bindParam(':movie_id',$movieId);
 $stmt->execute();

 return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//DISTINCT evite d'avoir deux fois le même film
public function search($text){
 $search='%' . $text . '%';
 $stmt=$this->pdo->prepare("SELECT DISTINCT movies.* FROM movies LEFT JOIN movies_directors ON movies.id=movies_directors.movie_id LEFT JOIN directors ON directors.id=movies_directors.director_id WHERE movies.title LIKE :title OR CONCAT(directors.first_name,' ',directors.last_name) LIKE :director ORDER BY movies.title ASC");
 $stmt->bindParam(':title', $search);
 $stmt->bindParam(':director',$search);
 $stmt->execute();

 return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}