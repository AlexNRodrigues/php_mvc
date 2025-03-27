<?php

namespace Controllers\Admin;

use Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $this->view->setLayout('layouts.admin')
            ->render('admin.index');
    }

    public function dashboard()
    {
        dd('Admin Dashboard');
    }
}