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

class TasksListService
{

    /**
     * Create a new task list
     *
     * @throws \Exception
     */
    public function create(string $title, int $categoryId, int $statusId): int
    {
        DB::connect();

        // Create the task list
        $sql = "INSERT INTO tasks_list (title, categoryId, statusId) VALUES (:title, :categoryId, :statusId)";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->bindParam(':statusId', $statusId);

            $stmt->execute();

            $listId = DB::$conn->lastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }

        DB::close();

        return $listId;
    }

    /**
     * @throws \Exception
     */
    public function getAll(): false|array
    {
        DB::connect();

        $sql = "SELECT * FROM tasks_list";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\TasksList');

            $tasksList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }

        DB::close();

        error_log(print_r($tasksList, true));

        return $tasksList;
    }

}
