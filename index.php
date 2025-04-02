<?php
// Démarre la session pour pouvoir accéder aux variables de session
session_start();

require_once __DIR__ . '/vendor/autoload.php';

// Importer les contrôleurs nécessaires
use App\Controllers\IndexController;
use App\Controllers\EntreprisesController;
use App\Controllers\ProfilController;
use App\Controllers\OfferController;
use App\Controllers\WishlistController;

// Créer une instance de Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

// Vérifier si l'utilisateur est connecté
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null; // On récupère l'utilisateur si connecté, sinon $user sera null

// Route demandée
$uri = $_GET['uri'] ?? '/'; // Utilise '/' pour la page d'accueil

// Traitement des différentes routes avec switch/case
switch ($uri) {
    case '/':
        // Passer l'objet $user (s'il existe) à la vue Twig, dans le layout
        $controller = new IndexController($twig);
        $controller->index($user); // Passe $user au contrôleur
        break;

    case 'Companies':
        $controller = new EntreprisesController($twig);
        $controller->EntreprisesPage($user);
        break;

    case 'Profil':
        $controller = new ProfilController($twig);
        $controller->ProfilPage($user);
        break;

    case 'Offer':
        $controller = new OfferController($twig);
        $controller->OfferPage($user);
        break;

    case 'Wishlist':
        $controller = new WishlistController($twig);
        $controller->WishlistPage($user);
        break;

    default:
        http_response_code(404);
        echo "Page '$uri' non trouvée.";
        break;
}
