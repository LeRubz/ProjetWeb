<?php
require "vendor/autoload.php";

use App\Controllers\OfferController;

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

if (isset($_GET['uri'])) {
    $uri = $_GET['uri'];
} else {
    $uri = '/';
}

$controller = new OfferController($twig);

switch ($uri) {
    case '/Offers':
        $controller->listOffers();  // Affiche la liste des offres
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
        break;
}
