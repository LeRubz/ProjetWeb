<?php
class UserModel {
    private $pdo;

    public function __construct() {

        $this->pdo = new PDO(
            'mysql:host=cesi-demo-projetweb.westeurope.cloudapp.azure.com;dbname=projetweb;charset=utf8mb4',
            'alexis',  
            '12345678',  
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]  
        );
    }
    

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($firstname, $lastname, $tel, $email, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO user (firstname, name, tel, email, password, admin_status) VALUES (?, ?, ?, ?, ?, 0)");
        return $stmt->execute([$firstname, $lastname, $tel, $email, $password]);
    }
}
?>
