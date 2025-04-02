<?php
namespace App\Controllers;

class StaticController extends Controller
{
    public function __construct($templateengine) {
        parent::__construct($templateengine);
    }

    public function aide() {
        echo $this->templateengine->render('aide.html.twig');
    }

    public function cgu() {
        echo $this->templateengine->render('cgu.html.twig');
    }

    public function cookies() {
        echo $this->templateengine->render('cookies.html.twig');
    }

    public function apropos() {
        echo $this->templateengine->render('apropos.html.twig');
    }

    public function mentions() {
        echo $this->templateengine->render('mentions_legales.html.twig');
    }
}
