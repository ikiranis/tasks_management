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
use apps4net\tasks\services\TeamsService;

class TeamsController extends Controller
{
    private TeamsService $teamsService;

    public function __construct()
    {
        parent::__construct();

        $this->teamsService = new TeamsService();
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
}
