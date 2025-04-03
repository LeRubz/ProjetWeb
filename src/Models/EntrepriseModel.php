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
                up_logo.NOM AS logo_name,  -- Récupérer le nom du fichier logo
                up_logo.EXTENSION AS logo_extension,  -- Récupérer l'extension du logo
                up_banner.NOM AS banner_name,  -- Récupérer le nom du fichier bannière
                up_banner.EXTENSION AS banner_extension,  -- Récupérer l'extension de la bannière
                a.CITY AS city 
            FROM company c
            LEFT JOIN address a ON c.ID_ADDRESS = a.ID_ADDRESS
            LEFT JOIN upload up_logo ON c.LOGO = up_logo.ID_UPLOAD -- Jointure avec la table UPLOAD pour le logo
            LEFT JOIN upload up_banner ON c.BANNER = up_banner.ID_UPLOAD -- Jointure avec la table UPLOAD pour la bannière
        ");
        $companies = $stmt->fetchAll();
        
        // Ajouter le chemin complet pour les logos et bannières
        foreach ($companies as &$company) {
            // Ajoute le chemin complet pour les logos
            $company['logo_path'] = 'images/logo/' . $company['logo_name'] . '.' . $company['logo_extension'];
            
            // Ajoute le chemin complet pour les bannières
            $company['banner_path'] = 'images/banner/' . $company['banner_name'] . '.' . $company['banner_extension'];
        }

        return $companies;
    }


    
    // Récupérer une entreprise par son ID avec les fichiers sécurisés
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
                a.CITY AS city,
                l.HASH AS logo_hash, 
                l.EXTENSION AS logo_ext, 
                b.HASH AS banner_hash, 
                b.EXTENSION AS banner_ext
            FROM company c
            LEFT JOIN address a ON c.ID_ADDRESS = a.ID_ADDRESS
            LEFT JOIN upload l ON c.LOGO = l.ID_UPLOAD
            LEFT JOIN upload b ON c.BANNER = b.ID_UPLOAD
            WHERE c.ID_COMPANY = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function searchCompanies($q = null, $location = null) {
        $sql = "
            SELECT 
                c.ID_COMPANY AS id, 
                c.NAME AS name, 
                c.DESCR AS descr, 
                c.NB_OFFER AS nb_offer, 
                c.MIDDLE_AGES AS middle_ages, 
                c.INDUSTRY AS industry, 
                c.EMPLOYEES AS employees, 
                up_logo.NOM AS logo_name, 
                up_logo.EXTENSION AS logo_extension, 
                up_banner.NOM AS banner_name, 
                up_banner.EXTENSION AS banner_extension, 
                a.CITY AS city 
            FROM company c
            LEFT JOIN address a ON c.ID_ADDRESS = a.ID_ADDRESS
            LEFT JOIN upload up_logo ON c.LOGO = up_logo.ID_UPLOAD
            LEFT JOIN upload up_banner ON c.BANNER = up_banner.ID_UPLOAD
            WHERE 1=1
        ";
    
        $params = [];
    
        if ($q) {
            $sql .= " AND (c.NAME LIKE ? OR c.INDUSTRY LIKE ?)";
            $params[] = '%' . $q . '%';
            $params[] = '%' . $q . '%';
        }
    
        if ($location) {
            $sql .= " AND (a.CITY LIKE ?)";
            $params[] = '%' . $location . '%';
        }
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $companies = $stmt->fetchAll();
    
        foreach ($companies as &$company) {
            $company['logo_path'] = 'images/logo/' . $company['logo_name'] . '.' . $company['logo_extension'];
            $company['banner_path'] = 'images/banner/' . $company['banner_name'] . '.' . $company['banner_extension'];
        }
    
        return $companies;
    }
    
    
    
    
    
}
