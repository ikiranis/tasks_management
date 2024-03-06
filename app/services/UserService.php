<?php
/**
 *
 * File: UserService.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 6/3/24
 * Time: 10:24 μ.μ.
 *
 */

namespace apps4net\tasks\services;

use apps4net\tasks\libraries\DB;
use apps4net\tasks\models\User;

class UserService
{
    /**
     * Check the login
     *
     * @throws \Exception
     */
    public function loginUser(string $username, string $password): bool
    {
        DB::connect();

        try {

            $stmt = DB::$conn->prepare("SELECT username, password FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);

            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\User');

            $user = $stmt->fetch();
        } catch (\PDOException $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }

        DB::close();

        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                $_SESSION['username'] = $username;
            }

            return true;
        } else {
            return false;
        }
    }
}
