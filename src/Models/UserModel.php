<?php

class UserModel {
    private $pdo;

    public function __construct($dbHost, $dbName, $dbUser, $dbPass) {
        try {
            $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    /**
     * Créer un compte utilisateur avec hashage du mot de passe.
     */
    public function createUser($nom, $prenom, $email, $tel, $mdp, $admin_status = 0) {
        $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);
        $query = "INSERT INTO USER (NOM, PRENOM, EMAIL, TEL, MDP, ADMIN_STATUS) VALUES (:nom, :prenom, :email, :tel, :mdp, :admin_status)";

        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'tel' => $tel,
            'mdp' => $hashedPassword,
            'admin_status' => $admin_status
        ]);
    }

    /**
     * Vérifier les identifiants de connexion.
     */
    public function loginUser($email, $mdp) {
        $query = "SELECT * FROM USER WHERE EMAIL = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($mdp, $user['MDP'])) {
            return $user; // Connexion réussie
        }
        return false; // Échec de connexion
    }

    /**
     * Vérifier si un email est déjà utilisé.
     */
    public function emailExists($email) {
        $query = "SELECT COUNT(*) FROM USER WHERE EMAIL = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
}
