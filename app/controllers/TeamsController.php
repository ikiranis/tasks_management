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
use apps4net\tasks\services\TeamsService;
use apps4net\tasks\services\UserService;

class TeamsController extends Controller
{
    private TeamsService $teamsService;
    private UserService $userService;

    public function __construct()
    {
        parent::__construct();

        $this->teamsService = new TeamsService();
        $this->userService = new UserService();
    }

    /**
     * Display the teams main view
     *
     * @return void
     */
    public function index(): void
    {
        $users = [];

        // Get all the users
        try {
            $users = $this->userService->getAll();
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }

        // Get the teams and return them
        try {
            $teams = $this->teamsService->getAll();

            App::view('teams', [
                'teams' => $teams,
                'users' => $users
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

        try {
            $team = $this->teamsService->createTeam($name);

            // Get the HTML of the tasks list component, to add it to the page, without refreshing
            $HTMLComponent = App::componentHTML('team', ['team' => $team]);

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
        // TODO check if user is not already in the team
        $teamId = (int)$_POST['team'];
        $userId = (int)$_POST['user'];

        try {
            $user = $this->teamsService->addUserToTeam($teamId, $userId);

            $HTMLComponent = App::componentHTML('user', ['user' => $user]);

            // Return success json response
            $this->returnSuccess(['user' => $user, 'HTMLComponent' => $HTMLComponent]);
        } catch (\Exception $e) {
            // Return error message
            $this->returnError(400, $e->getMessage());
        }
    }
}
