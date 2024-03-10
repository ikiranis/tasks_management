<?php
/**
 *
 * File: TasksListController.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 10/3/24
 * Time: 8:46 μ.μ.
 *
 */

namespace apps4net\tasks\controllers;

use apps4net\tasks\services\TasksListService;

class TasksListController extends Controller
{
    private TasksListService $tasksListService;

    public function __construct()
    {
        parent::__construct();

        $this->tasksListService = new TasksListService();
    }

    /**
     * Create a new task list
     *
     * @throws \Exception
     */
    public function createTasksList(): void
    {
        $title = $_POST['title'];
        $categoryId = (int)$_POST['category'];
        $statusId = 0;

        error_log('title: ' . $title);
        error_log('category: ' . $categoryId);

        try {
            $listId = $this->tasksListService->create($title, $categoryId, $statusId);
        } catch (\Exception $e) {
            // Return json response
            echo json_encode(['message' => $e->getMessage(), 'code' => 400]);
            return;
        }

        error_log("its ok " . $listId);
        // Return json response
        echo json_encode(['listId' => $listId, 'code' => 200]);
    }

}
