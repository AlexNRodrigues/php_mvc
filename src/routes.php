<?php
use Core\Route;
use Core\View;

$router = new Route();

$router->get('/login', 'AuthController', 'login');
$router->post('/login', 'AuthController', 'login');
$router->get('/logout', 'AuthController', 'logout');

// Rota para a raiz (/) usando uma closure
$router->get('/', function() {
    $view = new View();
    $view->setLayout('layouts.main')->render('layouts.home');
});

$router->get('/home', function () {
    echo 'home';
});

// // Rota para /teste usando uma closure com parâmetros dinâmicos
// $router->get('/teste/{id}', function($id) {
//     echo "Teste com ID: " . $id;
// });


// $router->prefix('/adm', function($router) {
//     $router->get('/', 'Admin\AdminController', 'index');
//     $router->get('/dashboard', 'Admin\AdminController', 'dashboard');
// });

// $router->prefix('/api', function($router) {
//     $router->prefix('/v1', function($router) {
//         $router->get('/users', function() {
//             echo "Rota aninhada /api/v1/users";
//         });
//     });
// });