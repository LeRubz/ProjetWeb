<?php
require_once __DIR__ . '/vendor/autoload.php';

// Liste des routes → contrôleur/méthode
$routes = [
    'index' => ['controller' => 'IndexController', 'method' => 'index'],
    'entreprises' => ['controller' => 'EntreprisesController', 'method' => 'index'],
    // Tu peux en ajouter d’autres ici comme :
    // 'offres' => ['controller' => 'OffresController', 'method' => 'index'],
];

// Route demandée
$page = $_GET['page'] ?? 'index';

// Est-ce que la route existe ?
if (array_key_exists($page, $routes)) {
    $controllerName = $routes[$page]['controller'];
    $method = $routes[$page]['method'];

    // Chargement du contrôleur
    $controllerFile = __DIR__ . '/' . $controllerName . '.php';

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controller = new $controllerName();

        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            http_response_code(500);
            echo "Méthode '$method' introuvable dans $controllerName.";
        }
    } else {
        http_response_code(500);
        echo "Contrôleur '$controllerName' introuvable.";
    }

} else {
    http_response_code(404);
    echo "Page '$page' non trouvée.";
}
