<?php
namespace App\Controllers;

abstract class Controller {
    protected $model1 = null;
    protected $model2 = null;
    protected $templateengine = null;
    
    // Constructeur de la classe Controller
    public function __construct($templateengine, $model1 = null, $model2 = null) {
        $this->templateengine = $templateengine;
        $this->model1 = $model1;
        $this->model2 = $model2;
    }
    
    // Méthode pour rendre une vue
    protected function render($view, $params = []) {
        echo $this->templateengine->render($view, $params);
    }
}
