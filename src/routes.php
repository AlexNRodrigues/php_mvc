<?php
use Core\Route;

$router = new Route();

// Rota para a raiz (/) usando uma closure
$router->get('/', function() {
    echo "Página inicial funcionando!";
});

// Rota para /teste usando uma closure com parâmetros dinâmicos
$router->get('/teste/{id}', function($id) {
    echo "Teste com ID: " . $id;
});


// Rotas para usuários
$router->get('/users', 'UserController', 'index');
$router->get('/users/show/{id}', 'UserController', 'show');
$router->post('/users/store', 'UserController', 'store');

// Adicione mais rotas aqui conforme necessário