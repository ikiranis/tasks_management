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

class MainController extends Controller
{
   public function index(): void
   {
       $this->view('index');
   }

   public function groups(): void
   {
         $this->view('groups');
   }

    public function login(): void
    {
            $this->view('login');
    }

    public function register(): void
    {
            $this->view('register');
    }

    public function tasks(): void
    {
            $this->view('tasks');
    }
}
