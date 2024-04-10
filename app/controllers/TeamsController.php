<?php
/**
 *
 * File: TeamsController.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 17/3/24
 * Time: 9:45 μ.μ.
 *
 */

namespace apps4net\tasks\controllers;

use apps4net\tasks\libraries\App;
use apps4net\tasks\models\User;
use apps4net\tasks\services\TasksListService;
use apps4net\tasks\services\TeamsService;
use apps4net\tasks\services\UserService;
use DOMDocument;
use ErrorException;
use XSLTProcessor;

class TeamsController extends Controller
{
    private TeamsService $teamsService;
    private UserService $userService;
    private TasksListService $tasksListService;

    public function __construct()
    {
        parent::__construct();

        $this->teamsService = new TeamsService();
        $this->userService = new UserService();
        $this->tasksListService = new TasksListService();
    }

    /**
     * Display the teams main view
     *
     * @return void
     */
    public function index(): void
    {
        $users = [];
        $tasksLists = [];

        // Get all the users
        try {
            $users = $this->userService->getAll();
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        try {
            $tasksLists = $this->tasksListService->getAll();
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        // Get the teams and return them
        try {
            $teams = $this->teamsService->getAll();

            App::view('teams', [
                'teams' => $teams,
                'users' => $users,
                'tasksLists' => $tasksLists
            ]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }

    /**
     * Create a new team
     *
     * @return void
     */
    public function createTeam(): void
    {
        $name = $_POST['name'];

        $users = [];
        $tasksLists = [];

        // Get all the users
        try {
            $users = $this->userService->getAll();
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        try {
            $tasksLists = $this->tasksListService->getAll();
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        try {
            $team = $this->teamsService->createTeam($name);

            // Get the HTML of the tasks list component, to add it to the page, without refreshing
            $HTMLComponent = App::componentHTML('team', [
                'team' => $team,
                'users' => $users,
                'tasksLists' => $tasksLists
            ]);

            // Return success json response
            $this->returnSuccess(['team' => $team, 'HTMLComponent' => $HTMLComponent]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }

    /**
     * Add a user to a team
     *
     * @return void
     */
    public function addUserToTeam(): void
    {
        // Get the team and user ids from form
        $teamId = (int)$_POST['team'];
        $userId = (int)$_POST['user'];

        try {
            $isUserInTeam = $this->teamsService->isUserInTeam($teamId, $userId);

            if ($isUserInTeam) {
                // Return error message
                $this->returnError(400, 'Ο χρήστης είναι ήδη στην ομάδα');
            }
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        try {
            // Add the user to the team
            $user = $this->teamsService->addUserToTeam($teamId, $userId);

            // Get the HTML of the user component, to add it to the page, without refreshing
            $HTMLComponent = App::componentHTML('user', ['user' => $user]);

            // Return success json response
            $this->returnSuccess(['user' => $user, 'HTMLComponent' => $HTMLComponent]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }

    /**
     * Export the teams to XML file
     *
     * @return void
     */
    public function exportTeamsToXML(): void
    {
        $xml = '';

        try {
            // Get the XML of the teams as an XML string
            $xml = $this->teamsService->getXML();
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        // Return success json response
        $this->returnSuccess(['xml' => $xml]);
    }

    /**
     * Display the transformed XML, with default.xsl
     *
     * @return void
     * @throws ErrorException
     */
    public function displayTranformedXML(): void
    {
        $xml = new DOMDocument();
        $xsl = new DOMDocument();
        $xsl->load('xsl/default.xsl');

        // Enable user error handling
        libxml_use_internal_errors(true);

        try {
            // Get the XML of the teams as an XML string
            $xmlString = $this->teamsService->getXML();

            $xml->loadXML($xmlString);

            if (!$xml->validate()) {
                // Get the validation errors
                $errors = libxml_get_errors();

                // If there are errors, throw an exception with the first error message
                if (!empty($errors)) {
                    throw new \Exception($errors[0]->message);
                }
            }
        } catch (\Exception $e) {
            // Display the errors

            echo "<p>The XML document is not valid according to its DTD</p>";

            echo '<p>' . $e->getMessage() . '</p>';

            exit();
        }

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);

        $transformed = $proc->transformToXML($xml);

        echo $transformed;

        // Clear the libxml error buffer
        libxml_clear_errors();
    }
}
