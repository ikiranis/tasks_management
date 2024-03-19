<?php

use apps4net\tasks\libraries\App;

?>

<!DOCTYPE html>
<html lang="en">

<?php App::component('head'); ?>

<body>
<div class="container">
    <?php App::component('header'); ?>

    <section class="mb-5">
        <div class="container text-center">
            <div class="row">
                <?php
                // Display the team components, for every item in array $teams
                foreach ($teams as $team) {
                    App::component('team', [
                        'team' => $team,
                        'users' => $users,
                        'tasksLists' => $tasksLists
                    ]);
                }
                ?>
            </div>

           <?php App::component('createTeamForm'); ?>

        </div>
    </section>

    <?php App::component('footer'); ?>
</div>
</body>
</html>

<?php
// Add external JavaScript file (teams.js) to page
App::script('teams');
?>
