<?php
namespace App\Controllers;

use App\Models\UserModel; // ✅ LIGNE IMPORTANTE AJOUTÉE
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
            case 'logout':
                logout();
                break;
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

function login($userModel) {
    session_start();

    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $mdp = $_POST['mdp'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email invalide.";
        header("Location: /ProjetWeb/");
        exit();
    }

    $user = $userModel->findByEmail($email);

    if ($user && isset($user['PASSWORD']) && password_verify($mdp, $user['PASSWORD'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => $user['ID_USER'],
            'prenom' => $user['FIRSTNAME'],
            'email' => $user['EMAIL'],
            'adminstatus' => $user['ADMIN_STATUS']
        ];
        $_SESSION['success'] = "Connexion réussie, bienvenue " . $user['FIRSTNAME'] . " !";
        header("Location: /ProjetWeb/");
        exit();
    } else {
        $_SESSION['error'] = "Identifiants incorrects.";
        header("Location: /ProjetWeb/");
        exit();
    }
}

function signup($userModel) {
    $firstname = $_POST['prenom'] ?? '';
    $lastname = $_POST['nom'] ?? '';
    $tel = $_POST['tel'] ?? '';
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mdp'] ?? '';

    if ($userModel->findByEmail($email)) {
        $message = "Cet email est déjà utilisé.";
        $type = "error";
    } else {
        $hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);
        if ($userModel->createUser($firstname, $lastname, $tel, $email, $hashedPassword)) {
            $message = "Inscription réussie ! Bienvenue 😊";
            $type = "success";
        } else {
            $message = "Une erreur est survenue lors de l'inscription.";
            $type = "error";
        }
    }

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            #loader-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: #f7f5fc;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                font-family: Arial, sans-serif;
                animation: fadeIn 0.5s ease-in-out;
            }
            #loader-message {
                font-size: 28px;
                font-weight: bold;
                margin-bottom: 30px;
                color: " . ($type === 'success' ? '#6c4bb6' : '#f44336') . ";
                text-align: center;
                padding: 0 20px;
                max-width: 80%;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            }
            .loader-circle {
                border: 12px solid #e0d9f4;
                border-top: 12px solid #6c4bb6;
                border-radius: 50%;
                width: 100px;
                height: 100px;
                animation: spin 1s linear infinite;
                box-shadow: 0 0 20px rgba(108, 75, 182, 0.4);
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
        `;
        document.head.appendChild(style);

        const overlay = document.createElement('div');
        overlay.id = 'loader-overlay';

        const message = document.createElement('div');
        message.id = 'loader-message';
        message.textContent = '$message';

        const loader = document.createElement('div');
        loader.className = 'loader-circle';

        overlay.appendChild(message);
        overlay.appendChild(loader);
        document.body.appendChild(overlay);

        setTimeout(() => {
            overlay.remove();
            window.location.href = '/ProjetWeb/';
        }, 3000);
    });
</script>";
}

function logout() {
    session_start();
    session_destroy();
    header('Location: /ProjetWeb/');
    exit;
}
