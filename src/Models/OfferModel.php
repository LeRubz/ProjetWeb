<?php
namespace App\Models;

use PDO;

class OfferModel {
    private $pdo;

    public function __construct() {
        // Establishing a PDO connection
        $this->pdo = new PDO(
            'mysql:host=cesi-demo-projetweb.westeurope.cloudapp.azure.com;dbname=projetweb;charset=utf8mb4',  // DSN (Data Source Name)
            'alexis',
            '12345678', 
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
    

    // Fonction pour récupérer toutes les offer
    public function getAllOffers() {
        $stmt = $this->pdo->query("SELECT * FROM offer");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction pour récupérer une offre par son ID
    public function getOfferById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM offer WHERE ID_OFFER = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
