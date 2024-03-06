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

use apps4net\tasks\services\UserService;

class UserController
{
    private UserService $userService;

    public function __construct()
    {
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
                echo "true";
            } else {
                echo "false";
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
