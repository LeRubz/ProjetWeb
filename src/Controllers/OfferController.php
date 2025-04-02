<?php
namespace App\Controllers;

use App\Models\OfferModel;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class OfferController extends Controller 
{

    public function __construct($templateengine) {
        parent::__construct($templateengine, new OfferModel());
    }

    // Méthode pour afficher la liste des offres
    public function OfferPage() {
        $offers = $this->model1->getAllOffers();  // Récupère toutes les offres via le modèle
        $this->render('Offers.html.twig', ['offers' => $offers]);  // Rendu de la vue avec les données
    }
}
