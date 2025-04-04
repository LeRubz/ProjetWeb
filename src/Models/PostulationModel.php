<?php
namespace App\Models;

use PDO;

class PostulationModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function getUserCV($userId) {
        $stmt = $this->pdo->prepare("SELECT CV FROM USER WHERE ID_USER = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    public function addPostulation($userId, $offerId, $cvId) {
        $stmt = $this->pdo->prepare("INSERT INTO POSTULATION (ID_USER, ID_OFFER, ID_CV) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $offerId, $cvId]);
    }
}
