<?php
namespace App\Controllers;

use App\Models\EntrepriseModel;

class EntreprisesController extends Controller 
{
    public function __construct($templateengine) {
        parent::__construct($templateengine, new EntrepriseModel());
    }

    // Méthode pour afficher la liste des entreprises
    public function EntreprisesPage() {
        $query = $_GET['q'] ?? null;
        $location = $_GET['location'] ?? null;

        if ($query || $location) {
            $companies = $this->model1->searchCompanies($query, $location);
        } else {
            $companies = $this->model1->getAllEntreprises();
        }

        $this->render('entreprises.html.twig', ['companies' => $companies]);
    }
}
