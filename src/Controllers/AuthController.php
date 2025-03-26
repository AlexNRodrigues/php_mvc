<?php

namespace Controllers;

use Core\Session;
use Repositories\ProfessorRepository;

class AuthController extends Controller {

    public function login() {
        if (Session::isLoggedIn()) {
            $this->router->redirect('/');
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numero = $_POST['numero'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $professor = new ProfessorRepository();

            if ($userData = $professor->authenticate($numero, $senha)) {
                Session::set('usuario_id', $userData->id);
                Session::set('usuario', $userData);
                Session::set('nivel_acesso', 'professor');
                $this->router->redirect('/');
            } else {
                $error = "Credenciais inválidas";

                $this->view->setLayout('layouts.main')
                    ->with(['error' => $error])
                    ->render('auth.login');
            }
        }

        $this->view->setLayout('layouts.main')->render('auth.login');
    }

    public function logout() {
        Session::destroy();
        $this->router->redirect('/login');
    }
}