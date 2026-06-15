<?php
namespace App\middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtMiddleware
{
    public function __invoke(Request $request, Handler $handler): Response
    {
        $cookies = $request->getCookieParams();
        $token = $cookies['token'] ?? '';

        if (!$token) {
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => 'Token não encontrado.']));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        try {
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));

            if ($decoded->type !== 'MANAGER') {
                $response = new Response();
                $response->getBody()->write(json_encode(['error' => 'Acesso negado.']));
                return $response->withStatus(403)->withHeader('Content-Type', 'application/json');
            }

            return $handler->handle($request);
        } catch (\Exception $e) {
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => 'Token inválido.']));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    }
}