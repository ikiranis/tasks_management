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
