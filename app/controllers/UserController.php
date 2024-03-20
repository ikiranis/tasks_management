<?php
/**
 *
 * File: UserController.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 6/3/24
 * Time: 10:14 μ.μ.
 *
 */

namespace apps4net\tasks\controllers;

use apps4net\tasks\libraries\App;
use apps4net\tasks\services\UserService;

class UserController extends Controller
{
    private UserService $userService; // User service to handle the user data

    public function __construct()
    {
        parent::__construct();

        $this->userService = new UserService();
    }

    /**
     * Check the login
     *
     * @return void
     */
    public function checkLogin(): void
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            $result = $this->userService->loginUser($username, $password);

            if ($result) {
                // Redirect page
                header("Location: /");
            } else {
                App::view('login');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Register a new user
     *
     * @return void
     */
    public function registerUser(): void
    {
        // Get the data from the form
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Register the user
        try {
            $this->userService->registerUser($username, $password, $name, $email);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        // Redirect to the login page
        App::view('login');
    }

    /**
     * Logout the user
     *
     * @return void
     */
    public function logout(): void
    {
        $_SESSION['username'] = null;
        $_SESSION['role'] = null;
        $_SESSION['userId'] = null;

        // Redirect to the index page
        header("Location: /");
    }

    public function checkUsername(): void
    {
        $username = $_GET['username'];

        try {
            $result = $this->userService->checkUsername($username);

            if ($result) {
                $this->returnSuccess(['exists' => true]);
            } else {
                $this->returnSuccess(['exists' => false]);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
