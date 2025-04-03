<?php
namespace App\Controllers;

use App\Models\ProfilModel;
use Twig\Environment;

class ProfilController extends Controller
{
    public function __construct(Environment $templateengine)
    {
        parent::__construct($templateengine, new ProfilModel());
    }

    public function ProfilPage()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }   
    
        $userId = $_SESSION['user']['ID_USER'] ?? $_SESSION['user']['id'];
        $user = $this->model1->getUserById($userId);
    
        // Si l'URL contient ?edit=1, on active le mode édition
        $editMode = isset($_GET['edit']) && $_GET['edit'] == '1';
    
        $this->render('Profil.html.twig', [
            'user' => $user,
            'editMode' => $editMode
        ]);
    }
    

    public function updateProfil()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    
        $userId = $_SESSION['user']['id'];
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $tel = $_POST['tel'] ?? '';
    
        // ✅ 1. Met à jour la BDD
        $this->model1->updateUser($userId, $nom, $prenom, $email, $tel);
    
        // ✅ 2. Recharge les infos à jour depuis la BDD
        $user = $this->model1->getUserById($userId);
    
        // ✅ 3. Mets à jour la session
        $_SESSION['user'] = [
            'id' => $user['ID_USER'],
            'prenom' => $user['FIRSTNAME'],
            'email' => $user['EMAIL'],
            'adminstatus' => $user['ADMIN_STATUS']
        ];
    
        // ✅ 4. Redirection vers la page profil
        header("Location: index.php?uri=Profil");
        exit;
    }


    public function deleteProfil()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['user'])) {
            echo "Pas connecté";
            exit;
        }
    
        $userId = $_SESSION['user']['id'];
    
        // TEST : voir si ça passe ici
        echo "Suppression utilisateur ID $userId";
        $this->model1->deleteUser($userId);
        session_destroy();
    
        header("Location: index.php");
        exit;
    }
    
    
    public function uploadCV() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    
        $userId = $_SESSION['user']['id'];
    
        if (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
            die('Erreur lors du téléchargement du fichier.');
        }
    
        $file = $_FILES['cv'];
    
        // Vérifie le type MIME
        if ($file['type'] !== 'application/pdf') {
            die('Seuls les fichiers PDF sont autorisés.');
        }
    
        $filename = $file['name'];
        $tmpPath = $file['tmp_name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
        $fileContent = file_get_contents($tmpPath);
        $hash = hash('sha256', $fileContent);
    
        // Destination physique (facultatif si tu stockes juste la référence)
        $destination = __DIR__ . '/../../uploads/cv/' . $hash . '.' . $ext;
        move_uploaded_file($tmpPath, $destination);
    
        // Insère dans la table UPLOAD
        $uploadId = $this->model1->insertCVUpload($filename, $file['type'], $hash, $ext);
    
        // Associe le CV à l'utilisateur
        $this->model1->setUserCV($userId, $uploadId);
    
        // Mets à jour la session si besoin
        $_SESSION['user']['cv'] = $uploadId;
    
        header("Location: index.php?uri=Profil");
        exit;
    }
    

    




}
