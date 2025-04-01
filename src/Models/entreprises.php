<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/EntreprisesController.php';

$controller = new EntreprisesController();

// Simple "routing" via paramètres URL
$page = $_GET['page'] ?? 'index';

if ($page === 'index') {
    $controller->index();
} elseif ($page === 'show' && isset($_GET['id'])) {
    $controller->show($_GET['id']);
} else {
    http_response_code(404);
    echo "Page non trouvée";
}
