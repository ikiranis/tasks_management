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
            App::view('404');
            exit();
        }
    }

    public function index(): void
    {
        App::view('index');
    }

    public function login(): void
    {
        App::view('login');
    }

    public function register(): void
    {
        App::view('register');
    }
}
