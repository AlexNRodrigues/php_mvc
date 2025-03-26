<?php

namespace Controllers;

use Core\Route;
use Core\Session;
use Core\View;

class Controller
{
    protected $router;
    protected $view;

    public function __construct()
    {
        Session::start();
        $this->router = new Route();
        $this->view = new View();
    }
}