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
                c.ID_COMPANY AS id, 
                c.NAME AS name, 
                c.DESCR AS descr, 
                c.NB_OFFER AS nb_offer, 
                c.MIDDLE_AGES AS middle_ages, 
                c.INDUSTRY AS industry, 
                c.EMPLOYEES AS employees, 
                c.LOGO AS logo, 
                c.BANNER AS banner, 
                a.CITY AS city 
            FROM company c
            LEFT JOIN address a ON c.ID_ADDRESS = a.ID_ADDRESS
        ");
        return $stmt->fetchAll();
    }
    
    // Récupérer une entreprise par son ID
    public function getEntrepriseById($id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                c.ID_COMPANY AS id, 
                c.NAME AS name, 
                c.DESCR AS descr, 
                c.NB_OFFER AS nb_offer, 
                c.MIDDLE_AGES AS middle_ages, 
                c.INDUSTRY AS industry, 
                c.EMPLOYEES AS employees, 
                c.LOGO AS logo, 
                c.BANNER AS banner, 
                a.CITY AS city 
            FROM company c
            LEFT JOIN address a ON c.ID_ADDRESS = a.ID_ADDRESS
            WHERE c.id_company = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
