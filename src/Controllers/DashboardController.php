<?php
namespace App\Controllers;

use App\Models\UserModel;
use Twig\Environment;

class DashboardController extends Controller
{
    public function __construct(Environment $templateengine)
    {
        parent::__construct($templateengine, new UserModel());
    }

    public function showDashboard()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        if (!isset($_SESSION['user']) || $_SESSION['user']['adminstatus'] < 1) {
            header('Location: index.php');
            exit;
        }

        $users = $this->model1->getAllUsers();
        $this->render('dashboard.html.twig', ['users' => $users]);
    }

    public function deleteUser($id)
    {
        $this->model1->deleteUser($id);
        header('Location: index.php?uri=Dashboard');
    }

    public function updateUser()
    {
        $id = $_POST['id'];
        $name = $_POST['nom'];
        $firstname = $_POST['prenom'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $status = $_POST['adminstatus'];

        $this->model1->updateUser($id, $name, $firstname, $email, $tel, $status);

        // Mettre à jour la session si l'utilisateur modifie son propre compte
        if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $id) {
            $_SESSION['user']['prenom'] = $firstname;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['adminstatus'] = $status;
        }

        header('Location: index.php?uri=Dashboard');
    }

    public function addUser()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Vérifie que c’est un super admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['adminstatus'] < 2) {
            header('Location: index.php');
            exit;
        }
    
        // Sécurise les données
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $tel = trim($_POST['tel'] ?? '');
        $password = $_POST['password'] ?? '';
        $status = intval($_POST['adminstatus'] ?? 0);
    
        if ($nom && $prenom && $email && $tel && $password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
            // Utilise la méthode commune
            $this->model1->createUser($prenom, $nom, $tel, $email, $hashedPassword, $status);
        }
    
        header('Location: index.php?uri=Dashboard');
        exit;
    }
    


}
