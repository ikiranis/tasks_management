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

use apps4net\tasks\libraries\App;
use apps4net\tasks\libraries\Permission;

class MainController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        // Check if the user has permission to access the page
        // If not, display 404 page

        if (!Permission::getPermissionFor(App::getCurrentPage())) {
            $this->view('404');
            exit();
        }
    }

    public function index(): void
    {
        $this->view('index');
    }

    public function teams(): void
    {
        $this->view('teams');
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
