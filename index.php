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
use App\Controllers\StaticController;
use App\Controllers\DashboardController;
use App\Controllers\DashboardCompanyController;

// Créer une instance de Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

$twig->addGlobal('currentUri', $_GET['uri'] ?? '');

$twig->addGlobal('app', (object)[
    'request' => (object)$_GET
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

    case 'Profil/update':
        $controller = new ProfilController($twig);
        $controller->updateProfil();
        break;

    case 'Profil/delete':
        $controller = new ProfilController($twig);
        $controller->deleteProfil();
        break;
        
        
        
        

    case 'Offer':
        $controller = new OfferController($twig);
        $controller->OfferPage($user);
        break;

    case 'Wishlist':
        $controller = new WishlistController($twig);
        $controller->WishlistPage($user);
        break;

    case 'Dashboard':
        $controller = new DashboardController($twig);
        $controller->showDashboard();
        break;
        
    case 'Dashboard/delete':
        $controller = new DashboardController($twig);
        $controller->deleteUser($_POST['id']);
        break;
        
        
    case 'Dashboard/update':
        $controller = new DashboardController($twig);
        $controller->updateUser();
        break;

    case 'Dashboard/add':
        $controller = new App\Controllers\DashboardController($twig);
        $controller->addUser();
        break;
        
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

    // Afficher le dashboard des entreprises
    case 'Dashboard-Company':
        $controller = new App\Controllers\DashboardCompanyController($twig);
        $controller->showDashboard();
        break;

    // Ajouter une entreprise
    case 'Dashboard/addCompany':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new App\Controllers\DashboardCompanyController($twig);
            $controller->addCompany();
        }
        break;

    // Mettre à jour une entreprise
    case 'Dashboard/updateCompany':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new App\Controllers\DashboardCompanyController($twig);
            $controller->updateCompany();
        }
        break;

    // Supprimer une entreprise
    case 'Dashboard/deleteCompany':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new App\Controllers\DashboardCompanyController($twig);
            $controller->deleteCompany($_POST['id']);
        }
        break;
    
        case 'Search':
            $query = $_GET['q'] ?? '';
            $location = $_GET['location'] ?? '';
        
            $offerModel = new \App\Models\OfferModel();
            $entrepriseModel = new \App\Models\EntrepriseModel();
        
            $matchedOffers = $offerModel->getFilteredOffers($query, $location);
            $matchedCompanies = $entrepriseModel->searchCompanies($query, $location);
        
            if (!empty($matchedOffers) && (empty($matchedCompanies) || count($matchedOffers) >= count($matchedCompanies))) {
                header("Location: index.php?uri=Offer&q=" . urlencode($query) . "&location=" . urlencode($location));
                exit;
            } elseif (!empty($matchedCompanies)) {
                header("Location: index.php?uri=Companies&q=" . urlencode($query) . "&location=" . urlencode($location));
                exit;
            } else {
                // Redirige vers la page précédente avec un paramètre pour afficher le pop-up
                // Récupérer l'URL précédente sans ses éventuels anciens paramètres
                $ref = strtok($_SERVER['HTTP_REFERER'], '?');
                // Rediriger vers la même page avec le paramètre noresult=1
                header("Location: {$ref}?noresult=1");

                exit;
            }
            
            break;
        
        
        
        

    default:
        http_response_code(404);
        echo "Page '$uri' non trouvée.";
        break;
}
