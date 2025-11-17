<?php
/**
 * Ponto de entrada da aplicação - Versão com Router
 */

declare(strict_types=1);

// Incluir o autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Incluir o constantes
require_once __DIR__ . '/../config/constants.php';

use App\Core\Router;

// Definir o path base da sua aplicação
$basePath = PATH;

// Criar e usar o router
$router = new Router($basePath);
$router->handle($_SERVER['REQUEST_URI']);
?>