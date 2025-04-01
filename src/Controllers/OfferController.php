<?php
namespace App\Controllers;

use App\Models\OfferModel;

class OfferController extends Controller {

    public function __construct($templateengine) {
        parent::__construct($templateengine, new OfferModel());
    }

    // Méthode pour afficher la liste des offres
    public function listOffers() {
        $offers = $this->model1->getAllOffers();  // Récupère toutes les offres via le modèle
        $this->render('Offers.html.twig', ['offers' => $offers]);  // Rendu de la vue avec les données
    }

    // Méthode pour afficher une offre spécifique par ID
    public function showOffer($id) {
        $offer = $this->model1->getOfferById($id);  // Récupère l'offre par ID
        if ($offer) {
            $this->render('OfferDetail.html.twig', ['offer' => $offer]);  // Rendu de la vue avec l'offre
        } else {
            $this->render('404.html.twig');
        }
    }
}
