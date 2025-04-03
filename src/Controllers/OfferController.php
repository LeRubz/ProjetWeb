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
        $query = $_GET['q'] ?? null;
        $location = $_GET['location'] ?? null;
        $entreprise = $_GET['entreprise'] ?? null;
        $domaine = $_GET['domaine'] ?? null;
    
        if ($query || $location) {
            $offers = $this->model1->getFilteredOffers($query, $location);
        } else {
            $offers = $this->model1->getOffersByFilters($entreprise, $domaine); 
        }
        
    
        // 👇 Nouveau : on récupère les données pour les menus déroulants
        $companies = $this->model1->getAllCompanies();
        $domaines = $this->model1->getAllDomains();
    
        $this->render('Offers.html.twig', [
            'offers' => $offers,
            'entreprise' => $entreprise,
            'domaine' => $domaine,
            'query' => $query,
            'location' => $location,
            'companies' => $companies,
            'domaines' => $domaines
        ]);
    }
    
}
