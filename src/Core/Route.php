<?php

namespace Core;

use Core\View;
use Closure;

class Route
{
    protected $routes = [];
    protected $requestMethod;
    protected $requestUri;
    protected $prefix = '';

    public function __construct()
    {
        // Obter o método HTTP e a URI da requisição
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->requestUri = isset($_GET['url']) ? '/' . rtrim($_GET['url'], '/') : '/';

        // Depuração: Exibir método e URI solicitados
        error_log("Método: " . $this->requestMethod . " | URI: " . $this->requestUri);
    }

    /**
     * Adiciona uma rota para o método GET
     * @param string $uri URI da rota
     * @param string|Closure $controller Nome do controlador ou closure
     * @param string|null $method Método do controlador (se aplicável)
     * @return void
     */
    public function get($uri, $controller, $method = null)
    {
        $fullUri = $uri === '/' 
            ? rtrim($this->prefix, '/') 
            : rtrim($this->prefix, '/') . '/' . ltrim($uri, '/');

        $this->addRoute('GET', $fullUri, $controller, $method);
    }

    /**
     * Adiciona uma rota para o método POST
     * @param string $uri URI da rota
     * @param string|Closure $controller Nome do controlador ou closure
     * @param string|null $method Método do controlador (se aplicável)
     * @return void
     */
    public function post($uri, $controller, $method = null)
    {
        // Concatenar o prefixo com a URI, normalizando barras
        $fullUri = rtrim($this->prefix, '/') . '/' . ltrim($uri, '/');
        $this->addRoute('POST', $fullUri, $controller, $method);
    }

    /**
     * Define um grupo de rotas com um prefixo comum
     * @param string $prefix Prefixo a ser adicionado às URIs
     * @param Closure $callback Função que define as rotas internas
     * @return void
     */
    public function prefix($prefix, Closure $callback)
    {
        // Salvar o prefixo atual e acumular o novo prefixo
        $originalPrefix = $this->prefix;
        $this->prefix = rtrim($originalPrefix, '/') . '/' . ltrim($prefix, '/');

        // Executar a closure, passando a instância atual
        call_user_func($callback, $this);

        // Restaurar o prefixo original após a execução
        $this->prefix = $originalPrefix;
    }

    /**
     * Adiciona uma rota genérica
     * @param string $method Método HTTP (GET, POST, etc.)
     * @param string $uri URI da rota
     * @param string|Closure $controller Nome do controlador ou closure
     * @param string|null $methodName Método do controlador (se aplicável)
     * @return void
     */
    protected function addRoute($method, $uri, $controller, $methodName)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'action' => $methodName,
            'pattern' => $this->convertToRegex($uri)
        ];

        // Depuração: Exibir rota adicionada
        error_log("Rota adicionada: [$method] $uri -> " . (is_callable($controller) ? 'Closure' : "$controller@$methodName"));
    }

    /**
     * Converte a URI em uma expressão regular para suportar parâmetros dinâmicos
     * @param string $uri URI da rota
     * @return string Expressão regular
     */
    protected function convertToRegex($uri)
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $uri);
        return "#^" . $pattern . "/?$#";
    }

    /**
     * Dispacha a requisição para a rota correspondente
     * @return void
     */
    public function dispatch()
    {
        // Depuração: Exibir todas as rotas registradas
        error_log("Rotas registradas: " . print_r($this->routes, true));

        foreach ($this->routes as $route) {
            if ($this->requestMethod === $route['method'] && preg_match($route['pattern'], $this->requestUri, $matches)) {
                error_log("Rota correspondida: " . $route['uri']);
                array_shift($matches); // Remove o primeiro elemento (match completo)
                return $this->handleRoute($route, $matches);
            }
        }

        // Rota não encontrada
        error_log("Nenhuma rota correspondida para " . $this->requestMethod . " " . $this->requestUri);
        $this->notFound();
    }

    /**
     * Manipula a execução da rota, suportando closures e controladores
     * @param array $route Dados da rota
     * @param array $params Parâmetros extraídos da URI
     * @return void
     */
    protected function handleRoute($route, $params = [])
    {
        $controller = $route['controller'];
        $action = $route['action'];

        // Se o controller for uma closure, executá-la diretamente
        if ($controller instanceof Closure) {
            return call_user_func_array($controller, $params);
        }

        // Caso contrário, chamar o controlador e método
        return $this->callController($controller, $action, $params);
    }

    /**
     * Chama o controlador e o método correspondente, passando parâmetros se necessário
     * @param string $controller Nome do controlador
     * @param string $method Método do controlador
     * @param array $params Parâmetros extraídos da URI
     * @return void
     */
    protected function callController($controller, $method, $params = [])
    {
        $controllerClass = "Controllers\\" . $controller;

        if (!class_exists($controllerClass)) {
            throw new \Exception("Controlador '$controllerClass' não encontrado.");
        }

        $controllerInstance = new $controllerClass();

        if (!method_exists($controllerInstance, $method)) {
            throw new \Exception("Método '$method' não encontrado no controlador '$controllerClass'.");
        }

        // Chamar o método do controlador, passando os parâmetros dinâmicos
        call_user_func_array([$controllerInstance, $method], $params);
    }

    /**
     * Exibe uma página de erro 404
     * @return void
     */
    protected function notFound()
    {
        http_response_code(404);
        $view = new View();
        $view->setLayout('layouts.main')
            ->with(['title' => '404 - Página Não Encontrada'])
            ->render('errors.404');
    }
}