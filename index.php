<?php
require_once __DIR__ . '/vendor/autoload.php';

// Importer les contrôleurs nécessaires
use App\Controllers\IndexController;
use App\Controllers\EntreprisesController;
use App\Controllers\ProfilController;
use App\Controllers\OfferController;
use App\Controllers\WishlistController;
use App\Controllers\StaticController; // <-- Nouveau

// Créer une instance de Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

// Route demandée
$uri = $_GET['uri'] ?? '/'; // Utilise '/' pour la page d'accueil

// Traitement des différentes routes avec switch/case
switch ($uri) {
    case '/':
        $controller = new IndexController($twig);
        $controller->index();
        break;

    case 'Companies':
        $controller = new EntreprisesController($twig);
        $controller->EntreprisesPage();
        break;

    case 'Profil':
        $controller = new ProfilController($twig);
        $controller->ProfilPage();
        break;

    case 'Offer':
        $controller = new OfferController($twig);
        $controller->OfferPage();
        break;

    case 'Wishlist':
        $controller = new WishlistController($twig);
        $controller->WishlistPage();
        break;

    // ✅ Routes statiques :
    case 'aide':
        $controller = new StaticController($twig);
        $controller->aide();
        break;

    case 'cgu':
        $controller = new StaticController($twig);
        $controller->cgu();
        break;

    case 'cookies':
        $controller = new StaticController($twig);
        $controller->cookies();
        break;

    case 'apropos':
        $controller = new StaticController($twig);
        $controller->apropos();
        break;

    case 'mentions':
        $controller = new StaticController($twig);
        $controller->mentions();
        break;

    default:
        http_response_code(404);
        echo "Page '$uri' non trouvée.";
        break;
}
