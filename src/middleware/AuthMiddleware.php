<?php
namespace App\middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response;

class AuthMiddleware
{
    // Middleware de autenticação que valida um token estático antes de permitir acesso a rota
    public function __invoke(Request $request, Handler $handler): Response
    {
        $token = $request->getHeaderLine('Authorization');

        if ($token !== $_ENV['LOG_API_TOKEN']) {
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => 'Token inválido.']));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}