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
use DOMImplementation;
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
        $implementation = new DOMImplementation();

        // Define your DTD
        $dtd = <<<DTD
<!DOCTYPE teams [
<!ELEMENT teams (team*)>
<!ELEMENT team (name, users, tasksLists)>
<!ATTLIST team id CDATA #REQUIRED>
<!ELEMENT name (#PCDATA)>
<!ELEMENT users (user+)>
<!ELEMENT user (username, name, email)>
<!ATTLIST user id CDATA #REQUIRED>
<!ELEMENT username (#PCDATA)>
<!ELEMENT email (#PCDATA)>
<!ELEMENT tasksLists (taskslist*)>
<!ELEMENT taskslist (tittle, category, status, tasks)>
<!ATTLIST taskslist id CDATA #REQUIRED>
<!ELEMENT tittle (#PCDATA)>
<!ELEMENT category (#PCDATA)>
<!ELEMENT status (#PCDATA)>
<!ELEMENT tasks (task*)>
<!ELEMENT task (title)>
<!ATTLIST task id CDATA #REQUIRED>
<!ELEMENT title (#PCDATA)>
]>
DTD;

        // Create a DOMDocumentType instance
        $dtd = $implementation->createDocumentType('teams', '', $dtd);

        // Create a new DOM document with the XML version and encoding
        $dom = $implementation->createDocument('1.0', '', $dtd);

        // Add utf-8 encoding
        $dom->encoding = 'UTF-8';

        // Create the root element
        $root = $dom->createElement('teams');
        $root = $dom->appendChild($root);

        $teams = $this->getAll();

        foreach ($teams as $team) {
            $teamElement = $dom->createElement('team');
            $teamElement->setAttribute('id', $team->getId());
            $teamElement = $root->appendChild($teamElement);

            $teamElement->appendChild($dom->createElement('name', $team->getName()));

            $users = $team->getUsers();

            $usersElement = $dom->createElement('users');
            $usersElement = $teamElement->appendChild($usersElement);

            foreach ($users as $user) {
                $userElement = $dom->createElement('user');
                $userElement->setAttribute('id', $user->getId());
                $userElement = $usersElement->appendChild($userElement);

                $userElement->appendChild($dom->createElement('username', $user->getUserName()));
                $userElement->appendChild($dom->createElement('name', $user->getName()));
                $userElement->appendChild($dom->createElement('email', $user->getEmail()));
            }

            $tasksLists = $team->getTasksLists();

            $tasksListsElement = $dom->createElement('tasksLists');
            $tasksListsElement = $teamElement->appendChild($tasksListsElement);

            foreach ($tasksLists as $tasksList) {
                $tasksListElement = $dom->createElement('taskslist');
                $tasksListElement->setAttribute('id', $tasksList->getId());
                $tasksListElement = $tasksListsElement->appendChild($tasksListElement);

                $tasksListElement->appendChild($dom->createElement('tittle', $tasksList->getTitle()));
                $tasksListElement->appendChild($dom->createElement('category', $tasksList->getCategoryName()));
                $tasksListElement->appendChild($dom->createElement('status', $tasksList->getStatusName()));

                $tasks = $tasksList->getTasks();

                $tasksElement = $dom->createElement('tasks');
                $tasksElement = $tasksListElement->appendChild($tasksElement);

                foreach ($tasks as $task) {
                    $taskElement = $dom->createElement('task');
                    $taskElement->setAttribute('id', $task->getId());
                    $taskElement = $tasksElement->appendChild($taskElement);

                    $taskElement->appendChild($dom->createElement('title', $task->getTitle()));
                }
            }
        }

        // Format the output to be readable
        $dom->formatOutput = true;

        return $dom->saveXML();
    }
}
