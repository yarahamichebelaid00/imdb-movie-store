<?php
require_once __DIR__ . '/../includes/db.php';

class director {
    private $pdo;

    public function __construct()
    {
        $this->pdo= getDbConnection();
    }

    public function getById($id){
        $stmt=$this->pdo->prepare("SELECT *FROM directors WHERE id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}