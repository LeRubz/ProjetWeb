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
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['ID_USER'];
        $user = $this->model1->getUserById($userId);

        $this->render('Profil.html.twig', ['user' => $user]);
    }
}
