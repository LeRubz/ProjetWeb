<?php
namespace App\Controllers;

use App\Models\EntrepriseModel;
use Twig\Environment;

class EntreprisesController extends Controller 
{
    public function __construct($templateengine) {
        parent::__construct($templateengine, new EntrepriseModel());
    }

    // Méthode pour afficher la liste des entreprises
    public function EntreprisesPage() {
        // On récupère toutes les entreprises via le modèle
        $companies = $this->model1->getAllEntreprises();
        
        // Passer les données à la vue
        $this->render('entreprises.html.twig', ['companies' => $companies]);
    }
    
}
