<?php
/**
 *
 * File: User.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 5/3/24
 * Time: 10:19 μ.μ.
 *
 */

namespace apps4net\tasks\models;

use apps4net\tasks\libraries\DB;
use JsonSerializable;

class User implements JsonSerializable
{
    private int $id;
    private string $username;
    private string $password;
    private string $name;
    private string $email;
    private int $role;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function setRole(int $role): void
    {
        $this->role = $role;
    }

    /**
     * Get the tasks lists of the user
     *
     * @throws \Exception
     */
    public function getTasksLists(): array
    {
        DB::connect();

        $sql = "SELECT tl.* FROM tasks_list tl JOIN list_users lu ON tl.id = lu.tasksListId WHERE lu.userId = :userId";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':userId', $this->id);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\TasksList');

            $tasksLists = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }

        DB::close();

        return $tasksLists;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role
        ];
    }
}
