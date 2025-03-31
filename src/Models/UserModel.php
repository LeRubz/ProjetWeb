<?php
class UserModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($email, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
        return $stmt->execute([$email, $password]);
    }
}
?>
