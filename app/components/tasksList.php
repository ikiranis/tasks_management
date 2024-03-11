<div class="col-lg-6 col-12 mb-3 mt-3 mb-lg-0">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="my-auto">
                <strong><?= $list->getTitle() ?></strong>
            </div>
            <div class="my-auto">
                <form id="taskForm<?= $list->getId() ?>" action="api/addTask" method="post"
                      class="bg-light d-none position-absolute form-inline" style="right: 10px;">
                    <div class="input-group">
                        <input type="text" id="title" name="title" class="form-control" placeholder="Τίτλος εργασίας">
                        <input type="hidden" name="tasksListId" value="<?= $list->getId() ?>">

                        <div class="input-group-append">
                            <button type="submit" title="Save task" class="btn saveButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" fill="green"
                                     class="bi bi-check-circle"
                                     viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </form>

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
                    <div class="text-center emptyTasks">Δεν υπάρχουν εργασίες</div>
                    <?php
                }

                foreach ($list->getTasks() as $task) {
                    ?>
                    <div id="task<?= $task->getId() ?>" class="d-flex justify-content-between">
                        <div><?= $task->getTitle() ?></div>
                        <div>
                            <a class="btn" onclick="deleteTask(<?= $task->getId() ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>


    </div>
</div>
