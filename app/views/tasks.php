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
            <div class="tasksListsContainer d-sm-block d-lg-flex flex-lg-row overflow-auto">
                <?php
                // Display the tasks lists components, for every item in array $tasksList
                foreach ($tasksList as $list) {
                    App::component('tasksList', [
                        'list' => $list,
                        'categories' => $categories,
                        'statuses' => $statuses
                    ]);
                }
                ?>
            </div>

            <?php App::component('createListForm', ['categories' => $categories]); ?>
        </div>

        <?php App::component('error'); ?>
    </section>

    <?php App::component('footer'); ?>
</div>
</body>
</html>

<?php
// Add external JavaScript file (tasks.js) to page
App::script('tasks');
?>
