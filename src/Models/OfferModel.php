<?php
namespace App\Models;

use PDO;

class OfferModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
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

    public function getFilteredOffers($entreprise = null, $domaine = null) {
        $sql = "SELECT o.*, c.NAME AS COMPANY_NAME
                FROM offer o
                JOIN company c ON o.ID_COMPANY = c.ID_COMPANY
                WHERE 1=1";
    
        $params = [];
    
        if ($entreprise) {
            $sql .= " AND c.NAME = ?";
            $params[] = $entreprise;
        }
    
        if ($domaine) {
            $sql .= " AND o.DOMAIN_ACT = ?";
            $params[] = $domaine;
        }
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
    
    
    
}
