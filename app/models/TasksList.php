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

class TasksList
{
    private int $id;
    private string $title;
    private int $category;
    private int $status;

    /**
     * @param int $id
     * @param string $title
     * @param int $category
     * @param int $status
     */
    public function __construct(int $id, string $title, int $category, int $status)
    {
        $this->id = $id;
        $this->title = $title;
        $this->category = $category;
        $this->status = $status;
    }

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

    public function getCategory(): int
    {
        return $this->category;
    }

    public function setCategory(int $category): void
    {
        $this->category = $category;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
