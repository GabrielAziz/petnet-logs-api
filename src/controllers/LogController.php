<?php
namespace App\controllers;

use App\services\LogService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\ValidationException;

class LogController
{
    private LogService $service;
    // Instancia o service responsável pela regra de negócio dos logs
    public function __construct()
    {
        $this->service = new LogService();
    }

    // Retorna todos os logs em formato JSON
    public function index(Request $request, Response $response): Response
    {
        $logs = $this->service->getAll();
        $response->getBody()->write(json_encode($logs));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Busca um log pelo ID e retorna 404 caso não exista
    public function show(Request $request, Response $response, array $args): Response
    {
        $log = $this->service->getById((int) $args['id']);

        if (!$log) {
            $response->getBody()->write(json_encode(['error' => 'Log não encontrado.']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($log));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Recebe os dados da requisição, chama o service para processar e retorna a resposta HTTP
    public function store(Request $request, Response $response): Response
    {
        try {
            $this->service->create($request->getParsedBody());
            $response->getBody()->write(json_encode(['message' => 'Log salvo com sucesso.']));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (ValidationException $e) {
            $errors = array_values(array_filter($e->getMessages()));
            $response->getBody()->write(json_encode(['error' => 'Dados inválidos.', 'details' => $errors]));
            return $response->withStatus(422)->withHeader('Content-Type', 'application/json');
        }
    }
}