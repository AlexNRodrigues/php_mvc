<?php

namespace Controllers;

use Repositories\UserRepository;
use Core\View;
use Models\User;

class UserController
{
    private $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function index()
    {
        $users = $this->repository->findAll();

        $view = new View();
        $view->setLayout('layouts.main')
            ->with([
                'users' => $users,
                'title' => 'Lista de Usuários'
            ])
            ->render('user.index');
    }

    public function show($id)
    {
        $user = $this->repository->findById($id);
        if (!$user) {
            http_response_code(404);
            echo "Usuário não encontrado";
            return;
        }

        $view = new View();
        $view->setLayout('layouts.main')
            ->with([
                'user' => $user,
                'title' => 'Detalhes do Usuário'
            ])
            ->render('user.show');
    }

    // Exemplo de método para criar um novo usuário (POST)
    public function store()
    {
        $user = new User();
        $user->name = $_POST['name'] ?? '';
        $user->email = $_POST['email'] ?? '';

        $this->repository->save($user);

        header('Location: /users');
        exit;
    }
}
