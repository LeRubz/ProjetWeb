<?php
namespace App\Controllers;

use App\Models\PostulationModel;

class PostulationController extends Controller
{
    public function __construct($templateengine) {
        parent::__construct($templateengine, new PostulationModel());
    }

    public function postuler() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user'])) {
            echo json_encode(['status' => 'not_logged']);
            exit;
        }

        $id_user = $_SESSION['user']['id'];
        $id_offer = $_POST['id_offer'] ?? null;

        if (!$id_offer) {
            echo json_encode(['status' => 'no_offer']);
            exit;
        }

        // Vérifie si l'utilisateur a un CV
        $cvId = $this->model1->getUserCV($id_user);
        if (!$cvId) {
            echo json_encode(['status' => 'no_cv']);
            exit;
        }

        // Insérer la postulation
        $this->model1->addPostulation($id_user, $id_offer, $cvId);

        echo json_encode(['status' => 'success']);
        exit;
    }
}
