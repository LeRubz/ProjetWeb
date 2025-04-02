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
            case 'logout': // Ajout du cas logout
                logout();
                break;
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

function login($userModel) {
    session_start(); // Démarre la session si elle n'est pas déjà démarrée

    // Récupération et nettoyage des entrées du formulaire
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $mdp = $_POST['mdp'] ?? '';

    // Vérification que l'email est valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email invalide.";
        header("Location: /ProjetWeb-1/");
        exit();
    }

    // Recherche de l'utilisateur dans la base de données
    $user = $userModel->findByEmail($email);

    // Vérification de l'utilisateur et du mot de passe
    if ($user && isset($user['PASSWORD']) && password_verify($mdp, $user['PASSWORD'])) {
        session_regenerate_id(true); // Sécurise la session
        $_SESSION['user'] = [
            'id' => $user['ID'],
            'prenom' => $user['FIRSTNAME'],
            'email' => $user['EMAIL'],
            'adminstatus' => $user['ADMIN_STATUS']
        ];
        $_SESSION['success'] = "Connexion réussie, bienvenue " . $user['FIRSTNAME'] . " !";
        header("Location: /ProjetWeb-1/"); // Redirection après connexion
        exit();
    } else {
        $_SESSION['error'] = "Identifiants incorrects.";
        header("Location: /ProjetWeb-1/");
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

    // Affichage du popup et redirection après 5s
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            let popup = document.createElement('div');
            popup.textContent = '$message';
            popup.style.position = 'fixed';
            popup.style.top = '20px';
            popup.style.left = '50%';
            popup.style.transform = 'translateX(-50%)';
            popup.style.backgroundColor = '" . ($type === 'success' ? '#896fbf' : '#f44336') . "';
            popup.style.color = 'white';
            popup.style.padding = '15px';
            popup.style.borderRadius = '5px';
            popup.style.boxShadow = '0px 0px 10px rgba(0, 0, 0, 0.2)';
            popup.style.zIndex = '1000';
            document.body.appendChild(popup);
            
            setTimeout(() => {
                popup.remove();
                window.location.href = '/ProjetWeb-1/'; // Redirection après suppression du popup
            }, 3000);
        });
    </script>";
}


function logout() {
    session_start(); // Démarrer la session pour pouvoir accéder à $_SESSION
    session_destroy(); // Détruire toutes les données de la session

    // Rediriger vers la page d'accueil après déconnexion
    header('Location: /ProjetWeb-1/');
    exit;
}
