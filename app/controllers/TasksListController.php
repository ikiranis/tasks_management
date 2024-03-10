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
        try {
            $tasksList = $this->tasksListService->getAll();

            App::view('tasks', ['tasksList' => $tasksList]);
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
        $statusId = 0;

        try {
            // Create the new tasks list in DB
            $tasksList = $this->tasksListService->create($title, $categoryId, $statusId);

            // Get the HTML of the tasks list component, to add it to the page, without refreshing
            $HTMLComponent = App::componentHTML('tasksList', ['list' => $tasksList]);

            // Return success json response
            $this->returnSuccess(['tasksList' => $tasksList, 'HTMLComponent' => $HTMLComponent]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }

}
