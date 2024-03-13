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
                // Display the tasks lists components, for every item in array $tasksList
                foreach ($tasksList as $list) {
                    App::component('tasksList', ['list' => $list]);
                }
                ?>
            </div>

            <form id="createListForm" action="api/createTasksList" method="POST" class="mt-5 row">
                <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                    <input type="text" class="form-control" placeholder="Τίτλος Λίστας" name="title"
                           aria-label="Τίτλος Λίστας">
                </div>

                <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                    <select class="form-select" name="category" aria-label="Κατηγορία">
                        <?php
                        // Display the categories options
                        foreach ($categories as $category) {
                            ?>
                            <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                    <button type="submit" class="form-control btn btn-primary">Δημιουργία
                        Λίστας
                    </button>
                </div>

            </form>
        </div>
    </section>

    <?php App::component('footer'); ?>
</div>
</body>
</html>

<?php
// Add external JavaScript file (tasks.js) to page
App::script('tasks');
?>
