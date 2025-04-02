<?php
namespace App\Models;

use PDO;


class UserModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
        if (!$stmt->execute([$email])) {
            echo "Erreur dans l'exécution de la requête : " . implode(" ", $stmt->errorInfo());
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function createUser($firstname, $lastname, $tel, $email, $password, $status = 0) {
        $stmt = $this->pdo->prepare("INSERT INTO user (firstname, name, tel, email, password, admin_status) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$firstname, $lastname, $tel, $email, $password, $status]);
    }
    
    

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM USER");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $name, $firstname, $email, $tel, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE USER SET NAME = ?, FIRSTNAME = ?, EMAIL = ?, TEL = ?, ADMIN_STATUS = ? WHERE ID_USER = ?");
        $stmt->execute([$name, $firstname, $email, $tel, $status, $id]);
    }

    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM USER WHERE ID_USER = ?");
        $stmt->execute([$id]);
    }

    /*public function createUserFromDashboard($firstname, $lastname, $tel, $email, $password, $status)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user (firstname, name, tel, email, password, admin_status) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$firstname, $lastname, $tel, $email, $password, $status]);
    }*/


}
?>
