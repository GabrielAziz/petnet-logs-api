<?php
require_once __DIR__ . '/../src/config/env.php';
// Carrega o autoload do Composer, responsável por localizar e carregar automaticamente as classes do projeto
require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;


// Cria a aplicação Slim
$app = AppFactory::create();

// Converte o body da requisição JSON em array PHP
$app->addBodyParsingMiddleware();

// Habilita tratamento de erros da aplicação
$app->addErrorMiddleware(false, true, true);

require_once __DIR__ . '/../src/routes/logs.php';

$app->run();