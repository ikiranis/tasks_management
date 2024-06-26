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

use apps4net\tasks\libraries\App;
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
     * Display the tasks main view
     *
     * @return void
     */
    public function index(): void
    {
        $categories = [];
        $statuses = [];

        // Get the categories for lists
        try {
            $categories = $this->tasksListService->getCategories();
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        // Get the statuses for lists
        try {
            $statuses = $this->tasksListService->getStatuses();
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        // Get the tasks lists and return them, with the categories
        try {
            $tasksList = $this->tasksListService->getAll();

            App::view('tasks', [
                'tasksList' => $tasksList,
                'categories' => $categories,
                'statuses' => $statuses
            ]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }

    /**
     * Create a new task list
     *
     * @throws \Exception
     */
    public function createTasksList(): void
    {
        // Get the data from the form
        $title = $_POST['title'];
        $categoryId = (int)$_POST['category'];
        $statusId = 1;  // StatusId for "Νέα"

        $categories = [];
        $statuses = [];

        // Get the categories for lists
        try {
            $categories = $this->tasksListService->getCategories();
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        // Get the statuses for lists
        try {
            $statuses = $this->tasksListService->getStatuses();
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        try {
            // Create the new tasks list in DB
            $tasksList = $this->tasksListService->create($title, $categoryId, $statusId);

            // Get the HTML of the tasks list component, to add it to the page, without refreshing
            $HTMLComponent = App::componentHTML('tasksList', [
                'list' => $tasksList,
                'categories' => $categories,
                'statuses' => $statuses
            ]);

            // Return success json response
            $this->returnSuccess(['tasksList' => $tasksList, 'HTMLComponent' => $HTMLComponent]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }

    /**
     * Update a tasks list
     *
     * @return void
     */
    public function updateTasksList(): void
    {
        // Get the data from the form
        $tasksListId = (int)$_POST['tasksListId'];
        $title = $_POST['title'];
        $categoryId = (int)$_POST['category'];
        $statusId = (int)$_POST['status'];
        $userId = (int)$_POST['userId'];

        try {
            // Update the tasks list in DB
            $tasksList = $this->tasksListService->updateTasksList($tasksListId, $title, $categoryId, $statusId, $userId);

            $categories = [];
            $statuses = [];

            // Get the categories for lists
            try {
                $categories = $this->tasksListService->getCategories();
            } catch (\Exception $e) {
                // Return error message
                $this->returnError(400, $e->getMessage());
            }

            // Get the statuses for lists
            try {
                $statuses = $this->tasksListService->getStatuses();
            } catch (\Exception $e) {
                // Return error message
                $this->returnError(400, $e->getMessage());
            }

            // Get the HTML of the tasks list component, to update it to the page, without refreshing
            $HTMLComponent = App::componentHTML('tasksList', [
                'list' => $tasksList,
                'categories' => $categories,
                'statuses' => $statuses
            ]);

            // Return success json response
            $this->returnSuccess(['tasksList' => $tasksList, 'HTMLComponent' => $HTMLComponent]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }

    /**
     * Add a task to a list
     *
     * @return void
     */
    public function addTask(): void
    {
        // Get the data from the form
        $title = $_POST['title'];
        $tasksListId = (int)$_POST['tasksListId'];

        try {
            // Create the new task in DB
            $task = $this->tasksListService->addTask($title, $tasksListId);

            // Get the HTML of the task component, to add it to the page, without refreshing
            $HTMLComponent = App::componentHTML('task', ['task' => $task]);

            // Return success json response
            $this->returnSuccess(['task' => $task, 'HTMLComponent' => $HTMLComponent]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }

    /**
     * Delete a task
     *
     * @return void
     */
    public function deleteTask(): void
    {
        // Get the data from the form
        $taskId = (int)$_POST['taskId'];

        try {
            // Delete the task from DB
            $this->tasksListService->deleteTask($taskId);

            // Return success json response
            $this->returnSuccess(['taskId' => $taskId]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }

    /**
     * Delete a tasks list
     *
     * @return void
     */
    public function deleteTasksList(): void
    {
        // Get the data from the form
        $tasksListId = (int)$_POST['tasksListId'];

        try {
            // Delete the task from DB
            $this->tasksListService->deleteTasksList($tasksListId);

            // Return success json response
            $this->returnSuccess(['tasksListId' => $tasksListId]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }

    /**
     * Add a user to a tasks list
     *
     * @return void
     */
    public function addUserToList(): void
    {
        // Get the data from the form
        $userId = (int)$_POST['user'];
        $tasksListId = (int)$_POST['tasksList'];

        try {
            $isUserInList = $this->tasksListService->isUserInList($userId, $tasksListId);

            if($isUserInList) {
                // Return error message
                $this->returnError(400, 'Η λίστα έχει ήδη ανατεθεί στον χρήστη');
            }
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        try {
            // Add the user to the tasks list
            $user = $this->tasksListService->addUserToTasksList($userId, $tasksListId);

            // Return success json response
            $this->returnSuccess(['user' => $user, 'message' => "Ο χρήστης προστέθηκε στην λίστα εργασιών"]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }
}
