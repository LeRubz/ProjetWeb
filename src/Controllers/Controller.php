<?php
namespace App\Controllers;

abstract class Controller {
    protected $model1 = null;
    protected $model2 = null;
    protected $templateengine = null;
    
    public function __construct($templateengine, $model1 = null, $model2 = null) {
        $this->templateengine = $templateengine;
        $this->model1 = $model1;
        $this->model2 = $model2;
    }

    protected function render($view, $params = []) {
        // Injecte l'utilisateur connecté sous le nom "sessionUser" pour le layout
        $params['sessionUser'] = $_SESSION['user'] ?? null;
    
        echo $this->templateengine->render($view, $params);
    }
    
}
