<?php
/**
 *
 * File: TeamsService.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 17/3/24
 * Time: 9:47 μ.μ.
 *
 */

namespace apps4net\tasks\services;

use apps4net\tasks\libraries\DB;
use apps4net\tasks\models\Team;

class TeamsService
{
    /**
     * Get all teams
     *
     * @return array
     * @throws \Exception
     */
    public function getAll(): array
    {
        DB::connect();

        $sql = "SELECT * FROM teams";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\Team');

            $teams = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }

        return $teams;
    }

    /**
     * Create a new team
     *
     * @throws \Exception
     */
    public function createTeam($name): Team
    {
        DB::connect();

        // Create the team
        $sql = "INSERT INTO teams (name) VALUES (:name)";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':name', $name);

            $stmt->execute();

            // Create Team object with the new data
            $team = new Team();

            $team->setId(DB::$conn->lastInsertId());
            $team->setName($name);
        } catch (\PDOException $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }

        return $team;
    }
}