<?php

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class IndexController
{
    private Environment $twig;

    public function __construct()
    {
        // Chemin des fichiers Twig
        $loader = new FilesystemLoader(__DIR__);
        $this->twig = new Environment($loader);
    }

    public function index()
    {
        // Aucune donnée dynamique nécessaire pour l'instant
        echo $this->twig->render('/../templates/index.html.twig');
    }
}
