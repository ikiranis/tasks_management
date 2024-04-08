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
        // Define the DTD for the XML document
        $implementation = new DOMImplementation();

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

        // Get all teams
        $teams = $this->getAll();

        foreach ($teams as $team) {
            // Create the team element
            $teamElement = $dom->createElement('team');

            // Set the team id as an attribute
            $teamElement->setAttribute('id', $team->getId());

            // Append the team element to the root
            $teamElement = $root->appendChild($teamElement);

            // Append the team name
            $teamElement->appendChild($dom->createElement('name', $team->getName()));

            // Get all users in the team
            $users = $team->getUsers();

            // Create the users element
            $usersElement = $dom->createElement('users');
            $usersElement = $teamElement->appendChild($usersElement);

            foreach ($users as $user) {
                // Create the user element
                $userElement = $dom->createElement('user');

                // Set the user id as an attribute
                $userElement->setAttribute('id', $user->getId());

                // Append the user element to the users element
                $userElement = $usersElement->appendChild($userElement);

                // Append the user data
                $userElement->appendChild($dom->createElement('username', $user->getUserName()));
                $userElement->appendChild($dom->createElement('name', $user->getName()));
                $userElement->appendChild($dom->createElement('email', $user->getEmail()));
            }

            // Get all tasks lists for the team
            $tasksLists = $team->getTasksLists();

            // Create the tasks lists element
            $tasksListsElement = $dom->createElement('tasksLists');
            $tasksListsElement = $teamElement->appendChild($tasksListsElement);

            foreach ($tasksLists as $tasksList) {
                // Create the tasks list element
                $tasksListElement = $dom->createElement('taskslist');

                // Set the tasks list id as an attribute
                $tasksListElement->setAttribute('id', $tasksList->getId());

                // Append the tasks list element to the tasks lists element
                $tasksListElement = $tasksListsElement->appendChild($tasksListElement);

                // Append the tasks list data
                $tasksListElement->appendChild($dom->createElement('tittle', $tasksList->getTitle()));
                $tasksListElement->appendChild($dom->createElement('category', $tasksList->getCategoryName()));
                $tasksListElement->appendChild($dom->createElement('status', $tasksList->getStatusName()));

                // Get the tasks for the tasks list
                $tasks = $tasksList->getTasks();

                // Create the tasks element
                $tasksElement = $dom->createElement('tasks');
                $tasksElement = $tasksListElement->appendChild($tasksElement);

                foreach ($tasks as $task) {
                    // Create the task element
                    $taskElement = $dom->createElement('task');

                    // Set the task id as an attribute
                    $taskElement->setAttribute('id', $task->getId());

                    // Append the task element to the tasks element
                    $taskElement = $tasksElement->appendChild($taskElement);

                    // Append the task data
                    $taskElement->appendChild($dom->createElement('title', $task->getTitle()));
                }
            }
        }

        // Format the output to be readable
        $dom->formatOutput = true;

        // Return the XML document as a string
        return $dom->saveXML();
    }
}
