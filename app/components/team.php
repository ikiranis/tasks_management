<?php

use apps4net\tasks\libraries\App;

?>

<div class="card col-12 mt-3">
    <h1 class="card-header"><?= $team?->getName() ?? 'Some team' ?></h1>

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
            <form id="addUserForm<?= $team?->getId() ?>" action="api/addUserToTeam" method="POST"
                  class="input-group mt-3 w-75 row mx-auto">
                <select class="form-select" name="user" aria-label="Χρήστης">
                    <?php
                    // Display the users options
                    foreach ($users as $user) {
                        ?>
                        <option value="<?= $user->getId() ?>"><?= $user->getUsername() ?></option>
                        <?php
                    }
                    ?>
                </select>

                <input type="hidden" name="team" value="<?= $team?->getId() ?>">

                <div class="col-12 col-lg-4 mt-2 mt-lg-0">
                    <button class="form-control btn btn-primary mx-1 text-nowrap" type="button"
                            onclick="addUserToTeam(<?= $team?->getId() ?>)">Προσθήκη
                        Μέλους
                    </button>
                </div>
            </form>
        </div>

        <form id="addUserToListForm<?= $team->getId() ?>" action="api/addUserToList" method="POST" class="row mt-5">
            <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                <select class="form-select mx-1" name="tasksList" aria-label="Εργασία">
                    <?php
                    // Display the tasks lists options
                    foreach ($tasksLists as $list) {
                        ?>
                        <option value="<?= $list->getId() ?>"><?= $list->getTitle() ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                <select class="form-select mx-1" name="user" aria-label="Μέλος">
                    <?php
                    // Display the users (of the team) options
                    foreach ($team->getUsers() as $user) {
                        ?>
                        <option value="<?= $user->getId() ?>"><?= $user->getUsername() ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                <button class="form-control btn btn-primary mx-1" type="button" onclick="addUserToList(<?= $team->getId() ?>)">Ανάθεση Εργασίας
                </button>
            </div>
        </form>
    </div>
</div>
