<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Definir a constante BASE_URL
define('BASE_URL', '/php_mvc/public');

// Carregar o arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require_once __DIR__ . '/../src/Core/Route.php';

use Core\Route;

$router = new Route();

require_once __DIR__ . '/../src/routes.php'; // Arquivo de definição de rotas


$router->dispatch();