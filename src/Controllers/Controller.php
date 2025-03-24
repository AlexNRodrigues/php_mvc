<?php

namespace Controllers;

use Core\Session;
use Core\View;

class Controller
{
    protected $view;

    public function __construct()
    {
        Session::start();
        $this->view = new View();
    }
}