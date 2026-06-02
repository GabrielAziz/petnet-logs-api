<?php
require_once __DIR__ . '/../src/config/env.php';
// Carrega o autoload do Composer, responsável por localizar e carregar automaticamente as classes do projeto
require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response;



// Cria a aplicação Slim
$app = AppFactory::create();

$allowedOrigins = array_map('trim', explode(',', $_ENV['FRONTEND_URLS'] ?? ''));
 
$app->add(function (Request $request, Handler $handler) use ($allowedOrigins): Response {
    $origin = $request->getHeaderLine('Origin'); // pega o cabeçalho http
    $allowOrigin = in_array($origin, $allowedOrigins) ? $origin : '';
 
    if ($request->getMethod() === 'OPTIONS') {
        $response = new Response();
        return $response
            ->withHeader('Access-Control-Allow-Origin', $allowOrigin)
            ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withStatus(200);
    }
 
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', $allowOrigin)
        ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
});

// Converte o body da requisição JSON em array PHP
$app->addBodyParsingMiddleware();

// Habilita tratamento de erros da aplicação
$app->addErrorMiddleware(false, true, true);

require_once __DIR__ . '/../src/routes/logs.php';

$app->run();