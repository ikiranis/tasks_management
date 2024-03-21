<?php
/**
 *
 * File: TasksListService.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 10/3/24
 * Time: 8:47 μ.μ.
 *
 */

namespace apps4net\tasks\services;

use apps4net\tasks\libraries\DB;
use apps4net\tasks\models\Task;
use apps4net\tasks\models\TasksList;
use apps4net\tasks\models\User;

class TasksListService
{

    /**
     * Create a new task list
     *
     * @throws \Exception
     */
    public function create(string $title, int $categoryId, int $statusId): TasksList
    {
        DB::connect();

        // Create the task list
        $sql = "INSERT INTO tasks_list (title, categoryId, statusId, userId) VALUES (:title, :categoryId, :statusId, :userId)";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->bindParam(':statusId', $statusId);
            $stmt->bindParam(':userId', $_SESSION['userId']);

            $stmt->execute();

            // Create TasksList object with the new data
            $tasksList = new TasksList();

            $tasksList->setId(DB::$conn->lastInsertId());
            $tasksList->setTitle($title);
            $tasksList->setCategoryId($categoryId);
            $tasksList->setStatusId($statusId);
            $tasksList->setUserId($_SESSION['userId']);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        // Add current user to the new list
        try {
            $user = $this->addUserToTasksList((int)$_SESSION['userId'], $tasksList->getId());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();

        return $tasksList;
    }

    /**
     * Update a task list
     *
     * @param int $tasksListId
     * @param string $title
     * @param int $categoryId
     * @param int $statusId
     * @param int $userId
     * @return TasksList
     *
     * @throws \Exception
     */
    public function updateTasksList(int $tasksListId, string $title, int $categoryId, int $statusId, int $userId): TasksList
    {
        DB::connect();

        // Update the task list
        $sql = "UPDATE tasks_list SET title = :title, categoryId = :categoryId, statusId = :statusId WHERE id = :tasksListId";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->bindParam(':statusId', $statusId);
            $stmt->bindParam(':tasksListId', $tasksListId);

            $stmt->execute();

            // Create TasksList object with the new data
            $tasksList = new TasksList();

            $tasksList->setId($tasksListId);
            $tasksList->setTitle($title);
            $tasksList->setCategoryId($categoryId);
            $tasksList->setStatusId($statusId);
            $tasksList->setUserId($userId);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();

        return $tasksList;
    }

    /**
     * Get all tasks lists for current user
     *
     * @return array
     * @throws \Exception
     */
    public function getAll(): array
    {
        DB::connect();

        // Get the tasks lists for the user (related with list_users table)
        $sql = "SELECT tl.* FROM tasks_list tl
                JOIN list_users lu ON tl.id = lu.tasksListId
                WHERE lu.userId = :userId
                ORDER BY tl.statusId ASC";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':userId', $_SESSION['userId']);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\TasksList');

            $tasksList = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();

        return $tasksList;
    }

    /**
     * Add a task to a list
     *
     * @param string $title
     * @param int $tasksListId
     * @return Task
     *
     * @throws \Exception
     */
    public function addTask(string $title, int $tasksListId): Task
    {
        DB::connect();

        $sql = "INSERT INTO tasks (title, tasksListId, userId) VALUES (:title, :tasksListId, :userId)";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':tasksListId', $tasksListId);
            $stmt->bindParam(':userId', $_SESSION['userId']);

            $stmt->execute();

            // Create Task object with the new data
            $task = new Task();

            $task->setId(DB::$conn->lastInsertId());
            $task->setTitle($title);
            $task->setTasksListId($tasksListId);
            $task->setUserId($_SESSION['userId']);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();

        return $task;
    }

    /**
     * Get the categories for lists
     *
     * @throws \Exception
     */
    public function getCategories(): array
    {
        DB::connect();

        $sql = "SELECT * FROM categories";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\Category');

            $categories = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();

        return $categories;
    }

    /**
     * Get the statuses for lists
     *
     * @return array
     * @throws \Exception
     */
    public function getStatuses(): array
    {
        DB::connect();

        $sql = "SELECT * FROM statuses";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\Status');

            $statuses = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();

        return $statuses;
    }

    /**
     * Delete a task
     *
     * @throws \Exception
     */
    public function deleteTask(int $taskId): void
    {
        DB::connect();

        $sql = "DELETE FROM tasks WHERE id = :taskId";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':taskId', $taskId);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();
    }

    /**
     * Delete a tasks list
     *
     * @throws \Exception
     */
    public function deleteTasksList(int $tasksListId): void
    {
        DB::connect();

        $sql = "DELETE FROM tasks_list WHERE id = :tasksListId";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':tasksListId', $tasksListId);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();
    }

    /**
     * Add a user to a tasks list
     *
     * @param int $userId
     * @param int $tasksListId
     * @return User
     * @throws \Exception
     */
    public function addUserToTasksList(int $userId, int $tasksListId): User
    {
        DB::connect();

        $sql = "INSERT INTO list_users (userId, tasksListId) VALUES (:userId, :tasksListId)";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':tasksListId', $tasksListId);
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
     * Check if user is already in list
     *
     * @throws \Exception
     */
    public function isUserInList(int $userId, int $tasksListId): bool
    {
        DB::connect();

        $sql = "SELECT * FROM list_users WHERE userId = :userId AND tasksListId = :tasksListId";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':tasksListId', $tasksListId);
            $stmt->execute();

            $result = $stmt->fetch();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        DB::close();

        return (bool)$result;
    }
}
