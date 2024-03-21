<?php

use apps4net\tasks\libraries\App;

?>

<div id="tasksList<?= $list->getId() ?>" class="tasksList col-4 mx-3 mb-5">

    <?php App::component('editListForm', [
        'list' => $list,
        'categories' => $categories,
        'statuses' => $statuses
    ]); ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between text-start">
            <div class="my-auto">
                <div>
                    <span><strong><?= $list->getTitle() ?></strong> (<?= $list->getStatusName() ?>)</span>

                    <!-- Set statusId value, to use in sort tasks lists -->
                    <input type="hidden" value="<?= $list->getStatusId() ?>" class="status"
                           id="status<?= $list->getId() ?>">
                </div>
                <div>
                    <small><?= $list->getCategoryName() ?></small>
                </div>
            </div>
            <div class="my-auto">
                <?php App::component('taskForm', ['list' => $list]); ?>

                <div class="d-flex">
                    <?php
                    // Display the edit and delete buttons, only if the user is the owner of the list
                    if ($list->getUserId() == $_SESSION['userId']) {
                        App::component('editListIcon', ['listId' => $list->getId()]);
                        App::component('deleteListIcon', ['listId' => $list->getId()]);
                    }

                    // Display the add task button
                    App::component('addTaskIcon', ['listId' => $list->getId()]);
                    ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-text">

                <?php
                if (count($list->getTasks()) == 0) {
                    ?>
                    <div class="text-center emptyList">Δεν υπάρχουν εργασίες</div>
                    <?php
                }

                foreach ($list->getTasks() as $task) {
                    App::component('task', ['task' => $task]);
                }
                ?>
            </div>
        </div>


    </div>
</div>
