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

        // Search for the user in the database
        try {
            $stmt = DB::$conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);

            $stmt->execute();

            // Get the user data as an object
            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\User');

            $user = $stmt->fetch();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();

        // If user exists
        if ($user) {
            // Check the password with the hashed password
            if (password_verify($password, $user->getPassword())) {
                // Set the session variables for the logged in user
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user->getRole();
                $_SESSION['userId'] = $user->getId();

                return true;
            }
        }

        return false;
    }

    /**
     * Register a new user with default user role
     *
     * @param string $username
     * @param string $password
     * @param string $name
     * @param string $email
     * @throws \Exception
     */
    public function registerUser(string $username, string $password, string $name, string $email): void
    {
        DB::connect();

        // Create a hashed password to save in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $defaultRole = 1;   // 1 = simple user, 0 = admin

        try {
            $stmt = DB::$conn->prepare("INSERT INTO users (username, password, name, email, role) VALUES (:username, :password, :name, :email, :role)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $defaultRole);

            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Get all users
     *
     * @throws \Exception
     */
    public function getAll(): array
    {
        DB::connect();

        $sql = "SELECT * FROM users";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\User');

            $users = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        return $users;
    }

    /**
     * Get a user by id
     *
     * @throws \Exception
     */
    public function getUserById(int $userId): User
    {
        DB::connect();

        $sql = "SELECT * FROM users WHERE id = :userId";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\User');

            $user = $stmt->fetch();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        return $user;
    }

    /**
     * Check if the username exists
     *
     * @param string $username
     * @return bool
     * @throws \Exception
     */
    public function checkUsername(string $username): bool
    {
        DB::connect();

        $sql = "SELECT * FROM users WHERE username = :username";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            // if the username exists return true
            if ($stmt->rowCount() > 0) {
                return true;
            }

            return false;
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
