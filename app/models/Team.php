<?php
/**
 *
 * File: Team.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 5/3/24
 * Time: 10:22 μ.μ.
 *
 */

namespace apps4net\tasks\models;

use apps4net\tasks\libraries\DB;
use apps4net\tasks\services\UserService;

class Team
{
    private int $id;
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get all users in a team
     *
     * @throws \Exception
     */
    public function getUsers(): array
    {
        DB::connect();

        // SQL to get the users in a team, based on table team_users (with teamId and userId fields)
        $sql = "SELECT u.* FROM users u JOIN team_users tu ON u.id = tu.userId WHERE tu.teamId = :teamId";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':teamId', $this->id);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\User');

            $users = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }

        return $users;
    }
}
