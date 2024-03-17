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
                        'team' => $team
                    ]);
                }
                ?>
            </div>

            <div class="row my-5">
                <form id="createTeamForm" action="api/createTeam" method="POST"
                      class="input-group mt-3 w-75 mx-auto row">
                    <div class="col-12 col-lg-8 mt-2 mt-lg-0">
                        <input type="text" class="form-control mx-1" name="name" placeholder="Όνομα Ομάδας"
                               aria-label="Όνομα Ομάδας">
                    </div>

                    <div class="col-12 col-lg-4 mt-2 mt-lg-0">
                        <button class="form-control btn btn-primary mx-1" type="submit">Προσθήκη Ομάδας</button>
                    </div>
                </form>
            </div>

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
