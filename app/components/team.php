<?php

use apps4net\tasks\libraries\App;

?>

<div class="card col-12 mt-3 px-0">
    <div class="card-header">
        <h1><?= $team?->getName() ?? 'Some team' ?></h1>
    </div>

    <div class="card-body">
        <div id="usersInTeam<?= $team->getId() ?>" class="d-flex justify-content-center mt-3">
            <?php
            // Display the users in the team
            foreach ($team->getUsers() as $user) {
                App::component('user', ['user' => $user]);
            }
            ?>
        </div>

        <div class="row">
           <?php App::component('addUserToTeamForm', ['team' => $team, 'users' => $users]); ?>
        </div>

       <?php App::component('addUserToListForm', ['team' => $team, 'tasksLists' => $tasksLists]); ?>
    </div>
</div>
