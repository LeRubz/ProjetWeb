<?php
namespace App\Models;

use PDO;

class EntrepriseModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    // Récupérer toutes les entreprises
    public function getAllEntreprises() {
        $stmt = $this->pdo->query("
            SELECT 
                c.id_company AS id, 
                c.name AS name, 
                c.descr AS descr, 
                c.nb_offer AS nb_offer, 
                c.middle_ages AS middle_ages, 
                c.industry AS industry, 
                c.employees AS employees, 
                c.logo AS logo, 
                c.banner AS banner, 
                a.city AS city 
            FROM company c
            LEFT JOIN address a ON c.id_address = a.id_address
        ");
        return $stmt->fetchAll();
    }
    
    // Récupérer une entreprise par son ID
    public function getEntrepriseById($id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                c.id_company AS id, 
                c.name AS name, 
                c.descr AS descr, 
                c.nb_offer AS nb_offer, 
                c.middle_ages AS middle_ages, 
                c.industry AS industry, 
                c.employees AS employees, 
                c.logo AS logo, 
                c.banner AS banner, 
                a.city AS city 
            FROM company c
            LEFT JOIN address a ON c.id_address = a.id_address
            WHERE c.id_company = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
