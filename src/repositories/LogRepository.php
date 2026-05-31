<?php

namespace App\repositories;

use App\db\Connection;
use PDO;

class LogRepository
{
    //armazena a conexão PDO
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("
        SELECT * FROM logs
        ORDER BY created_at DESC
    ");
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->pdo->prepare("
        SELECT * FROM logs WHERE id = :id
    ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $data): void
    {
        // Prepara a consulta SQL com parâmetros nomeados para execução segura
        $stmt = $this->pdo->prepare("
            INSERT INTO logs (entity, action, status, responsible, details, created_at)
            VALUES (:entity, :action, :status, :responsible, :details, :created_at)
        ");
        // Executa a consulta substituindo os parâmetros pelos valores recebidos
        $stmt->execute([
            ':entity'      => $data['entity'],
            ':action'      => $data['action'],
            ':status'      => $data['status'],
            ':responsible' => $data['responsible'] ?? null,
            ':details'     => $data['details'] ?? null,
            ':created_at'  => $data['created_at'],
        ]);
    }
}
