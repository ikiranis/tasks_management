<?php
/**
 *
 * File: MainController.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 4/3/24
 * Time: 10:48 μ.μ.
 *
 * Display the main views
 *
 */

namespace apps4net\tasks\controllers;

use apps4net\tasks\libraries\Permission;

class MainController extends Controller
{
    public function index(): void
    {
        if (!Permission::getPermissionFor('index')) {
            $this->view('404');
        }

        $this->view('index');
    }

    public function groups(): void
    {
        if (!Permission::getPermissionFor('teams')) {
            $this->view('404');
        }

        $this->view('teams');
    }

    public function login(): void
    {
        if (!Permission::getPermissionFor('login')) {
            $this->view('404');
        }

        $this->view('login');
    }

    public function register(): void
    {
        if (!Permission::getPermissionFor('register')) {
            $this->view('404');
        }

        $this->view('register');
    }

    public function tasks(): void
    {
        if (!Permission::getPermissionFor('tasks')) {
            $this->view('404');
        }

        $this->view('tasks');
    }
}
