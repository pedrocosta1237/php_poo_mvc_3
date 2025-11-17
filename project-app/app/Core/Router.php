<?php
/**
 * Classe de Roteamento
 * Gerencia as rotas da aplicação com namespaces
 */

declare(strict_types=1);

namespace App\Core;

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\UserController;

class Router 
{
    private string $basePath;

    public function __construct(string $basePath = '') 
    {
        $this->basePath = $basePath;
    }

    /**
     * Processa a requisição e encaminha para o controlador apropriado
     * @param string $request URI da requisição
     * @return void
     */
    public function handle(string $request): void 
    {
        // Remover o path base da URI
        if (!empty($this->basePath) && strpos($request, $this->basePath) === 0) {
            $request = substr($request, strlen($this->basePath));
        }

        // Se ficar vazio, redirecionar para home
        if ($request === '' || $request === '/') {
            $request = '/';
        }

        // Remover parâmetros da query string
        if (strpos($request, '?') !== false) {
            $request = substr($request, 0, strpos($request, '?'));
        }

        // Definir rotas
        $this->dispatch($request);
    }

    /**
     * Encaminha a requisição para o controlador apropriado
     * @param string $uri URI processada
     * @return void
     */
    private function dispatch(string $uri): void 
    {
        switch ($uri) {
            case '/':
            case '':
                $controller = new HomeController();
                $controller->index();
                break;
                
            case '/login':
                $controller = new AuthController();
                $controller->showLogin();
                break;
                
            case '/auth/login':
                $controller = new AuthController();
                $controller->login();
                break;
                
            case '/auth/logout':
                $controller = new AuthController();
                $controller->logout();
                break;
                
            case '/users':
                $controller = new UserController();
                $controller->index();
                break;
                
            case '/users/create':
                $controller = new UserController();
                $controller->create();
                break;
                
            case (preg_match('/\/users\/edit\/(\d+)/', $uri, $matches) ? true : false):
                $controller = new UserController();
                $controller->edit((int)$matches[1]);
                break;
                
            case '/users/save':
                $controller = new UserController();
                $controller->save();
                break;
                
            case (preg_match('/\/users\/delete\/(\d+)/', $uri, $matches) ? true : false):
                $controller = new UserController();
                $controller->delete((int)$matches[1]);
                break;
                
            default:
                $this->show404();
                break;
        }
    }

    /**
     * Mostra página 404
     * @return void
     */
    private function show404(): void 
    {
        http_response_code(404);
        echo "<div class='container mt-4'><h1>404 - Página não encontrada</h1>";
        echo "<p>A página solicitada não existe.</p>";
        echo "<a href='{$this->basePath}/' class='btn btn-primary'>Voltar para Home</a></div>";
    }
}
?>