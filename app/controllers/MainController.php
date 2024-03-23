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

class MainController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display the main page
     *
     * @return void
     */
    public function index(): void
    {
        App::view('index');
    }
}
