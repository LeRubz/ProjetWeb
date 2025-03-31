<?php

namespace App\Controllers;

use App\Models\TaskModel;
use Twig\Environment;

class TaskController {

    public function companyPage() {
        $filePath =  'entreprises.txt';
        $entreprises = json_decode(file_get_contents($filePath), true);

        $page = $_GET['page'] ?? 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $totalPages = ceil(count($entreprises) / $perPage);
        $entreprises = array_slice($entreprises, $offset, $perPage);

        echo $this->twig->render('company.twig.html', [
            'entreprises' => $entreprises,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }
}