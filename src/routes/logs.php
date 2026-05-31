<?php
use App\controllers\LogController;
use App\middleware\AuthMiddleware;

// Define as rotas de /logs e protege elas com o middleware de autenticação
$app->group('/logs', function ($group) {
    $group->get('',        [LogController::class, 'index']); //caminho e nome da função
    $group->get('/{id}',   [LogController::class, 'show']);
    $group->post('',       [LogController::class, 'store']);
})->add(AuthMiddleware::class);