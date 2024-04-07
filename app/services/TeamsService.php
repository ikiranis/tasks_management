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
use DOMDocument;
use SimpleXMLElement;

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

    /**
     * Export teams to XML
     *
     * @throws \DOMException
     * @throws \Exception
     */
    public function getXML(): string
    {
        // Create a new DOM document with the XML version and encoding
        $dom = new DOMDocument('1.0', 'UTF-8');

        // Create the root element
        $root = $dom->createElement('TEAMS');
        $root = $dom->appendChild($root);

        $teams = $this->getAll();

        foreach ($teams as $team) {
            $teamElement = $dom->createElement('TEAM');
            $teamElement = $root->appendChild($teamElement);

            $teamElement->appendChild($dom->createElement('ID', $team->getId()));
            $teamElement->appendChild($dom->createElement('NAME', $team->getName()));

            $users = $team->getUsers();

            $usersElement = $dom->createElement('USERS');
            $usersElement = $teamElement->appendChild($usersElement);

            foreach ($users as $user) {
                $userElement = $dom->createElement('USER');
                $userElement = $usersElement->appendChild($userElement);

                $userElement->appendChild($dom->createElement('ID', $user->getId()));
                $userElement->appendChild($dom->createElement('NAME', $user->getName()));
                $userElement->appendChild($dom->createElement('EMAIL', $user->getEmail()));
                $userElement->appendChild($dom->createElement('ROLE', $user->getRole()));

                $tasksLists = $user->getTasksLists();

                $tasksListsElement = $dom->createElement('TASKSLISTS');
                $tasksListsElement = $userElement->appendChild($tasksListsElement);

                foreach ($tasksLists as $tasksList) {
                    $tasksListElement = $dom->createElement('TASKSLIST');
                    $tasksListElement = $tasksListsElement->appendChild($tasksListElement);

                    $tasksListElement->appendChild($dom->createElement('ID', $tasksList->getId()));
                    $tasksListElement->appendChild($dom->createElement('TITTLE', $tasksList->getTitle()));
                }
            }

        }

        // Format the output to be readable
        $dom->formatOutput = true;

        return $dom->saveXML();
    }
}
