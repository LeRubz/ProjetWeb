<?php
namespace App\Models;

use PDO;

class ProfilModel {
    private $pdo;

    public function __construct() {

            $this->pdo = new PDO(
                'mysql:host=cesi-demo-projetweb.westeurope.cloudapp.azure.com;dbname=projetweb;charset=utf8mb4',  
                'alexis',  
                '12345678',  
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]  
            );
        
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM USER WHERE ID_USER = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
