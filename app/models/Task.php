<?php
/**
 *
 * File: Task.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 5/3/24
 * Time: 10:21 μ.μ.
 *
 */

namespace apps4net\tasks\models;

use JsonSerializable;

class Task implements JsonSerializable
{
    private int $id;
    private string $title;
    private int $tasksListId;
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

    public function getTasksListId(): int
    {
        return $this->tasksListId;
    }

    public function setTasksListId(int $tasksListId): void
    {
        $this->tasksListId = $tasksListId;
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
     * Return json representation of the object, to use it from JavaScript
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title
        ];
    }
}
