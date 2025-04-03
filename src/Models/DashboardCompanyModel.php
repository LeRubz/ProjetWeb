<?php
namespace App\Models;

use PDO;

class DashboardCompanyModel
{
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    // Fonction pour enregistrer un fichier dans la table `upload`
    public function uploadFile($file, $folder)
{
    // Vérifiez si le fichier est bien un tableau avec les informations nécessaires
    if (is_array($file)) {
        // Définir le répertoire où le fichier sera téléchargé
        // Ici, on s'assure que le répertoire est images/{logo, banner}
        $uploadDir = 'images/' . $folder . '/';  // Utilisation de "images/{logo, banner}"
        
        // Vérifier si le répertoire existe sinon le créer
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Gérer le fichier, calculer son hash et son extension
        $fileName = $file['name'];
        $fileTmpPath = $file['tmp_name'];
        $fileHash = hash('sha256', $fileName . time());  // Calculer le hash pour éviter les doublons
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);  // Obtenir l'extension du fichier
        $filePath = $uploadDir . $fileHash . '.' . $fileExtension;  // Le chemin complet du fichier
        
        // Déplacer le fichier téléchargé dans le bon répertoire
        if (move_uploaded_file($fileTmpPath, $filePath)) {
            // Insérer le fichier dans la table UPLOAD avec les informations nécessaires
            $sql = "INSERT INTO upload (nom, type, hash, extension) VALUES (:nom, :type, :hash, :extension)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':nom' => $fileName,
                ':type' => $file['type'],
                ':hash' => $fileHash,
                ':extension' => $fileExtension
            ]);

            // Retourner l'ID du fichier inséré dans la base de données
            return $this->pdo->lastInsertId();
        }
    }

    // Si quelque chose va mal, retourner false
    return false;
}

    


public function createCompany($name, $descr, $nb_offer, $middle_ages, $industry, $employees, $city, $road, $num, $country, $postal_code, $logoFile, $bannerFile)
{
    // Première étape : Insérer l'adresse dans la table 'address'
    $sql = "INSERT INTO address (country, postal_code, city, road, num) 
            VALUES (:country, :postal_code, :city, :road, :num)";
    
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        ':country' => $country,
        ':postal_code' => $postal_code,
        ':city' => $city,
        ':road' => $road,
        ':num' => $num
    ]);
    
    // Récupérer l'ID de l'adresse insérée
    $addressId = $this->pdo->lastInsertId();

    // Étape 1 : Gérer l'upload du logo et de la bannière
    $logoId = $this->uploadFile($logoFile, 'logos');
    $bannerId = $this->uploadFile($bannerFile, 'banners');

    if ($logoId && $bannerId) {
        // Insérer l'entreprise dans la table 'company'
        $sql = "INSERT INTO company (name, descr, nb_offer, middle_ages, industry, employees, address_id, logo, banner)
                VALUES (:name, :descr, :nb_offer, :middle_ages, :industry, :employees, :address_id, :logo, :banner)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':descr' => $descr,
            ':nb_offer' => $nb_offer,
            ':middle_ages' => $middle_ages,
            ':industry' => $industry,
            ':employees' => $employees,
            ':address_id' => $addressId,  // Utilisation de l'ID de l'adresse insérée
            ':logo' => $logoId,           // Utilisation de l'ID du logo
            ':banner' => $bannerId        // Utilisation de l'ID de la bannière
        ]);
    }

    return false;
}




    public function getCompanies()
    {
        // Récupérer les entreprises avec leurs informations d'adresse et fichiers (logo, banner)
        $sql = "SELECT c.ID_COMPANY, c.NAME, c.DESCR, c.NB_OFFER, c.MIDDLE_AGES, c.INDUSTRY, c.EMPLOYEES, 
                a.COUNTRY, a.POSTAL_CODE, a.CITY, a.ROAD, a.NUM, 
                l.NOM AS LOGO_NAME, l.TYPE AS LOGO_TYPE, l.HASH AS LOGO_HASH, l.EXTENSION AS LOGO_EXTENSION,
                b.NOM AS BANNER_NAME, b.TYPE AS BANNER_TYPE, b.HASH AS BANNER_HASH, b.EXTENSION AS BANNER_EXTENSION
                FROM company c
                LEFT JOIN address a ON c.ID_ADDRESS = a.ID_ADDRESS
                LEFT JOIN upload l ON c.LOGO = l.ID_UPLOAD
                LEFT JOIN upload b ON c.BANNER = b.ID_UPLOAD";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // Retourner toutes les entreprises
        return $stmt->fetchAll();
    }
}


