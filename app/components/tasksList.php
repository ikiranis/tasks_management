<?php

use apps4net\tasks\libraries\App;

?>

<div id="tasksList<?= $list->getId() ?>" class="tasksList col-lg-6 col-12 mb-3 mt-3 mb-lg-0">

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
                    <input type="hidden" value="<?= $list->getStatusId() ?>" class="status" id="status<?= $list->getId() ?>">
                </div>
                <div>
                    <small><?= $list->getCategoryName() ?></small>
                </div>
            </div>
            <div class="my-auto">
                <?php App::component('taskForm', ['list' => $list]); ?>

                <a class="btn" title="Επεξεργασία Λίστας" onclick="editTasksList(<?= $list->getId() ?>)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                    </svg>
                </a>

                <a class="btn" title="Διαγραφή Λίστας" onclick="deleteTasksList(<?= $list->getId() ?>)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                </a>

                <a class="btn" title="Προσθήκη εργασίας" onclick="addTask(<?= $list->getId() ?>)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-calendar2-plus" viewBox="0 0 16 16">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z"/>
                        <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5zM8 8a.5.5 0 0 1 .5.5V10H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V11H6a.5.5 0 0 1 0-1h1.5V8.5A.5.5 0 0 1 8 8"/>
                    </svg>
                </a>
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
