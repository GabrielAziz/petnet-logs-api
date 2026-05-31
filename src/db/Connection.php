<?php
namespace App\db;

use PDO;
use PDOException;

class Connection
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) { // Verifica se já existe uma conexão com o banco, se não existir, cria uma nova
            require_once __DIR__ . '/../config/env.php';

            try {
                self::$instance = new PDO(
                    "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4",
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASSWORD']
                );
                // Configura como os dados serão retornados
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Erro de conexão com o banco.']);
                exit;
            }
        }
        //Retorna o objeto PDO que está guardado
        return self::$instance;
    }
}