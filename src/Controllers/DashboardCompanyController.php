<?php
namespace App\Controllers;

use App\Models\DashboardCompanyModel;

class DashboardCompanyController
{
    private $model;
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
        $this->model = new DashboardCompanyModel();  // Initialisation du modèle ici
    }

    public function showDashboard()
    {
        // Logique pour afficher le tableau de bord des entreprises
        $companies = $this->model->getCompanies(); // Par exemple, récupérer toutes les entreprises
        echo $this->twig->render('dashboard-company.html.twig', ['companies' => $companies]);
    }

    public function addCompany()
{
    if (isset($_POST['name'], $_POST['descr'], $_POST['nb_offer'], $_POST['middle_ages'], $_POST['industry'], $_POST['employees'], $_POST['city'], $_POST['road'], $_POST['num'], $_POST['country'], $_POST['postal_code'])) {
        // Récupération des données du formulaire
        $name = $_POST['name'];
        $descr = $_POST['descr'];
        $nb_offer = $_POST['nb_offer'];
        $middle_ages = $_POST['middle_ages'];
        $industry = $_POST['industry'];
        $employees = $_POST['employees'];
        $city = $_POST['city'];
        $road = $_POST['road'];
        $num = $_POST['num'];
        $country = $_POST['country'];
        $postal_code = $_POST['postal_code'];

        // Gérer les uploads de fichiers
        if (isset($_FILES['logo']) && isset($_FILES['banner'])) {
            // Vérifier que $_FILES['logo'] et $_FILES['banner'] contiennent les bons tableaux
            if (is_array($_FILES['logo']) && is_array($_FILES['banner'])) {
                // Upload du logo
                $logoId = $this->model->uploadFile($_FILES['logo'], 'logos');

                // Upload de la bannière
                $bannerId = $this->model->uploadFile($_FILES['banner'], 'banners');

                // Insérer les données de l'entreprise dans la base de données avec les IDs du logo et de la bannière
                $this->model->createCompany($name, $descr, $nb_offer, $middle_ages, $industry, $employees, $city, $road, $num, $country, $postal_code, $logoId, $bannerId);
            } else {
                // Gérer les erreurs si les fichiers ne sont pas envoyés correctement
                echo "Erreur dans l'upload des fichiers.";
            }
        }
    }

    // Redirection après l'ajout de l'entreprise
    header('Location: index.php?uri=Dashboard-Company');
    exit;
}


}

