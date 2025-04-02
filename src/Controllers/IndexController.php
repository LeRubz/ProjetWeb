<?php
namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class IndexController extends Controller
{
    // Le constructeur de IndexController
    public function __construct($templateengine)
    {
        parent::__construct($templateengine);
    }

    // Méthode pour afficher la page d'accueil
    public function index($user)
    {
        // Vérifier si un utilisateur est connecté et passer l'objet $user à Twig
        $this->render('index.html.twig', ['user' => $user]);
    }
}









