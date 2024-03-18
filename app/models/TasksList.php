<?php
/**
 *
 * File: TasksList.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 5/3/24
 * Time: 10:25 μ.μ.
 *
 */

namespace apps4net\tasks\models;

use apps4net\tasks\libraries\DB;

class TasksList
{
    private int $id;
    private string $title;
    private int $categoryId;
    private int $statusId;
    private int $userId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getStatusId(): int
    {
        return $this->statusId;
    }

    public function setStatusId(int $statusId): void
    {
        $this->statusId = $statusId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * Get the category name for the current list
     *
     * @throws \Exception
     */
    public function getCategoryName(): string
    {
        DB::connect();

        $sql = "SELECT * FROM categories WHERE id = :categoryId";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':categoryId', $this->categoryId);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\Category');

            $category = $stmt->fetch();
        } catch (\PDOException $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }

        DB::close();

        return $category->getName();
    }

    /**
     * Get the status name for the current list
     *
     * @throws \Exception
     */
    public function getStatusName(): string
    {
        DB::connect();

        $sql = "SELECT * FROM statuses WHERE id = :statusId";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':statusId', $this->statusId);
            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\Status');

            $status = $stmt->fetch();
        } catch (\PDOException $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }

        DB::close();

        return $status->getName();
    }

    /**
     * Get the tasks for the current list
     *
     * @throws \Exception
     */
    public function getTasks(): array
    {
        // Get the tasks for the current list
        DB::connect();

        $sql = "SELECT * FROM tasks WHERE tasksListId = :tasksListId ORDER BY title ASC";

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':tasksListId', $this->id);
            $stmt->execute();

            // Get the tasks as an array of objects
            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\apps4net\tasks\models\Task');

            $tasks = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }

        DB::close();

        return $tasks;
    }
}
