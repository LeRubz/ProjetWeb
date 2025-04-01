<?php
namespace App\Models;

class EntrepriseModel {

    // Méthode pour récupérer toutes les entreprises
    public function getAllEntreprises() {
        // Simuler la récupération de données depuis la base
        return [
            ['id' => 1, 'nom' => 'Buffalo Grill', 'ville' => 'Guyancourt'],
            ['id' => 2, 'nom' => 'Azaé', 'ville' => 'Nantes']
        ];
    }

    // Méthode pour récupérer une entreprise par son ID
    public function getEntrepriseById($id) {
        $entreprises = $this->getAllEntreprises();
        foreach ($entreprises as $entreprise) {
            if ($entreprise['id'] == $id) {
                return $entreprise;
            }
        }
        return null;  // Retourne null si l'entreprise n'est pas trouvée
    }
}
