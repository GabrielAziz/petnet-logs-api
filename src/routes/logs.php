<?php
use App\controllers\LogController;
use App\middleware\AuthMiddleware;
use App\middleware\JwtMiddleware;

// Define as rotas de /logs e protege elas com o middleware de autenticação
$app->group('/logs', function ($group) {
    $group->get('',      [LogController::class, 'index'])->add(JwtMiddleware::class);
    $group->get('/{id}', [LogController::class, 'show'])->add(JwtMiddleware::class);
    $group->post('',     [LogController::class, 'store'])->add(AuthMiddleware::class);
});