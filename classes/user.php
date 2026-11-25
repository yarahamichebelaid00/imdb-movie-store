<?php
require_once __DIR__ . '/../includes/db.php';

class User {
    private $pdo;
    public function __construct()
    {
     $this->pdo =getDbConnection();
}

public function getById($id){
    $stmt=$this->pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
//REMPLACE l'ancien mot de passe par le nouveau
public function updatePassword($id, $hashedPassword){
    $stmt=$this->pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
    $stmt->bindParam(':password' ,$hashedPassword);
    $stmt->bindParam(':id', $id);
    
    return $stmt->execute();
}   
}