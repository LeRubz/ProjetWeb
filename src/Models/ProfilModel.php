<?php
namespace App\Models;

use PDO;

class ProfilModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
    

    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM USER WHERE ID_USER = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $nom, $prenom, $email, $tel) {
        $stmt = $this->pdo->prepare("UPDATE USER SET NAME = ?, FIRSTNAME = ?, EMAIL = ?, TEL = ? WHERE ID_USER = ?");
        $stmt->execute([$nom, $prenom, $email, $tel, $id]);
    }
    

    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM USER WHERE ID_USER = ?");
        $stmt->execute([$id]);
    }
    
    

}
