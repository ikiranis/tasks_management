<form id="editListForm<?= $list->getId() ?>" action="api/editTasksListTitle" method="post"
      class="bg-light d-none position-absolute form-inline" style="right: 10px;">
    <div class="input-group">
        <input type="text" id="title" name="title" class="form-control" placeholder="<?= $list->getTitle() ?>">
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
