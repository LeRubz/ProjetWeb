<?php
namespace App\Controllers;

use App\Models\EntrepriseModel;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class EntreprisesController extends Controller 
{

    public function __construct($templateengine) {
        parent::__construct($templateengine, new EntrepriseModel());
    }

    // Méthode pour afficher la liste des entreprises
    public function EntreprisesPage() {
        // On récupère toutes les entreprises via le modèle
        //$entreprises = $this->model1->getAllEntreprises(); 
        $this->render('entreprises.html.twig');  // Rendu de la vue avec les données
    }

}
