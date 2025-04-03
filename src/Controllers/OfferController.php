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
        $entreprise = $_GET['entreprise'] ?? null;
        $domaine = $_GET['domaine'] ?? null;
        
        $offers = $this->model1->getFilteredOffers($entreprise, $domaine);
        
    
        $this->render('Offers.html.twig', [
            'offers' => $offers,
            'entreprise' => $entreprise,
            'domaine' => $domaine
        ]);
    }
    
    
}
