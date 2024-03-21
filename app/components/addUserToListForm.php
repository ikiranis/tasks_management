<form id="addUserToListForm<?= $team->getId() ?>" action="api/addUserToList" method="POST" class="row mt-5">
    <div class="col-12 col-lg-6 mt-2 mt-lg-0">
        <select class="form-select mx-1" name="tasksList" id="tasksList" aria-label="Εργασία">
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
        <select class="form-select mx-1" name="user" id="user" aria-label="Μέλος">
            <?php
            // Get users in team and check if there are any
            $users = $team->getUsers();

            if (count($users) == 0) {
                ?>
                <option value="" disabled selected>Επιλογή χρήστη</option>
                <?php
            } else {
                // Display the users (of the team) options
                foreach ($team->getUsers() as $user) {
                    ?>
                    <option value="<?= $user->getId() ?>"><?= $user->getUsername() ?></option>
                    <?php
                }
            }
            ?>
        </select>
    </div>

    <div class="col-12 col-lg-3 mt-2 mt-lg-0">
        <button class="form-control btn btn-primary mx-1" type="button"
                onclick="addUserToList(<?= $team->getId() ?>)">Ανάθεση Εργασίας
        </button>
    </div>
</form>
