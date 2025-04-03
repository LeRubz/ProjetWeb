<?php
namespace App\Controllers;

use App\Models\OfferModel;

class OfferController extends Controller 
{
    public function __construct($templateengine) {
        parent::__construct($templateengine, new OfferModel());
    }

    // Méthode pour afficher les offres avec ou sans filtres/recherche
    public function OfferPage() {
        // Vérifie s'il y a une recherche via barre globale
        $query = $_GET['q'] ?? null;
        $location = $_GET['location'] ?? null;

        // Vérifie s'il y a un filtrage via les menus déroulants (entreprise ou domaine)
        $entreprise = $_GET['entreprise'] ?? null;
        $domaine = $_GET['domaine'] ?? null;

        if ($query || $location) {
            // Recherche globale (barre en haut)
            $offers = $this->model1->getFilteredOffers($query, $location);
        } else {
            // Filtres spécifiques
            $offers = $this->model1->getFilteredOffers($entreprise, $domaine);
        }

        $this->render('Offers.html.twig', [
            'offers' => $offers,
            'entreprise' => $entreprise,
            'domaine' => $domaine,
            'query' => $query,
            'location' => $location
        ]);
    }
}
