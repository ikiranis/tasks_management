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
use apps4net\tasks\models\User;

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
            throw new \Exception($e->getMessage());
        }

        return $teams;
    }

    /**
     * Create a new team
     *
     * @param string $name
     * @return Team
     * @throws \Exception
     */
    public function createTeam(string $name): Team
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
            throw new \Exception($e->getMessage());
        }

        return $team;
    }

    /**
     * Add a user to a team
     *
     * @param int $teamId
     * @param int $userId
     * @return User
     * @throws \Exception
     */
    public function addUserToTeam(int $teamId, int $userId): User
    {
        DB::connect();

        // Add the user to the team
        $sql = "INSERT INTO team_users (teamId, userId) VALUES (:teamId, :userId)";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':teamId', $teamId);
            $stmt->bindParam(':userId', $userId);

            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        // Get the user data
        try {
            $userService = new UserService();
            $user = $userService->getUserById($userId);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();

        return $user;
    }

    /**
     * Check if user is already in team
     *
     * @param int $teamId
     * @param int $userId
     * @return bool
     * @throws \Exception
     */
    public function isUserInTeam(int $teamId, int $userId): bool
    {
        DB::connect();

        $sql = "SELECT * FROM team_users WHERE teamId = :teamId AND userId = :userId";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':teamId', $teamId);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $result = $stmt->fetch();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();

        return (bool)$result;
    }
}
