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
        header('Location: /ProjetWeb-1/index.html');
        exit;
    } else {
        $_SESSION['error'] = 'Identifiants incorrects';
        header('Location: /ProjetWeb-1/index.html');
        exit;
    }
}

function signup($userModel) {
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mdp'] ?? '';

    if ($userModel->findByemail($email)) {
        $_SESSION['error'] = 'email déjà utilisé.';
        header('Location: /ProjetWeb-1/index.html');
        exit;
    }

    $hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);
    $userModel->createUser($email, $hashedPassword);
    $_SESSION['user'] = $userModel->findByemail($email)['id'];

    header('Location: /ProjetWeb-1/index.html');
    exit;
}

function logout() {
    session_destroy();
    header('Location: /ProjetWeb-1/index.html');
    exit;
}
?>
