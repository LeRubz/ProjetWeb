<?php
session_start();
require_once __DIR__ . '/../Models/UserModel.php';

$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'login':
                login($userModel);
                break;
            case 'signup':
                signup($userModel);
                break;
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

function login($userModel) {
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mdp'] ?? '';

    $user = $userModel->findByemail($email);
    if ($user && password_verify($mdp, $user['password'])) {
        $_SESSION['user'] = $user['id'];
        header('Location: /ProjetWeb-1/');
        exit;
    } else {
        $_SESSION['error'] = 'Identifiants incorrects';
        header('Location: /ProjetWeb-1/');
        exit;
    }
}

function signup($userModel) {
    $firstname = $_POST['prenom'] ?? '';
    $lastname = $_POST['nom'] ?? '';
    $tel = $_POST['tel'] ?? '';
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mdp'] ?? '';

    if ($userModel->findByEmail($email)) {
        $_SESSION['message'] = "Cet email est déjà utilisé.";
        $_SESSION['type'] = "error";
        header('Location: /ProjetWeb-1/src/View/transition.php');
        exit;
    }

    $hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);
    if ($userModel->createUser($firstname, $lastname, $tel, $email, $hashedPassword)) {
        $_SESSION['message'] = "Inscription réussie ! Bienvenue 😊";
        $_SESSION['type'] = "success";
    } else {
        $_SESSION['message'] = "Une erreur est survenue lors de l'inscription.";
        $_SESSION['type'] = "error";
    }

    header('Location: /ProjetWeb-1/');
    exit;
}


function logout() {
    session_destroy();
    header('Location: /ProjetWeb-1/index.html');
    exit;
}
?>
