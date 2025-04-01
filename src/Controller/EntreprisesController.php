<?php

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class EntreprisesController
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__);
        $this->twig = new Environment($loader);
    }

    public function index()
    {
        $entreprises = [
            ['nom' => 'Buffalo Grill', 'ville' => 'Guyancourt'],
            ['nom' => 'Azaé', 'ville' => 'Nantes']
        ];

        echo $this->twig->render('/../templates/entreprises.html.twig', [
            'entreprises' => $entreprises
        ]);
    }

    public function show($id)
    {
        $entreprise = ['nom' => 'Entreprise ID ' . $id];
        echo $this->twig->render('entreprise_detail.html.twig', [
            'entreprise' => $entreprise
        ]);
    }
}
