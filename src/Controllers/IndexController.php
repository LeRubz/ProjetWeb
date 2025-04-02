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
    public function index()
    {
        // Utilisation de la méthode render du parent pour afficher la vue index.html.twig
        $this->render('index.html.twig');
    }
}


