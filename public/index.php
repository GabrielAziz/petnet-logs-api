<?php

// Importa o autoload do Composer (slim e dependencias)
require_once __DIR__ . '/../vendor/autoload.php';

// Importa o slim framework
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// converte json
$app->addBodyParsingMiddleware();


$app->get('/health', function ($request, $response) {

    $text = "A api está ONLINE";

    $response->getBody()->write($text);

    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
