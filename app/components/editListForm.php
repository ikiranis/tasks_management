<form id="editListForm<?= $list->getId() ?>" action="api/updateTasksList" method="post"
      class="listForm bg-light d-none position-fixed mt-3 mx-3 border border-secondary p-2">
    <div class="col-12 mt-2">
        <input type="text" class="form-control" placeholder="Τίτλος Λίστας" name="title" value="<?= $list->getTitle() ?>"
               aria-label="Τίτλος Λίστας">
    </div>

    <input type="hidden" name="tasksListId" value="<?= $list->getId() ?>">

    <div class="col-12 mt-2">
        <select class="form-select" name="category" aria-label="Κατηγορία">
            <?php
            // Display the categories options
            foreach ($categories as $category) {
                ?>
                <option value="<?= $category->getId() ?>" <?= $category->getId() == $list->getCategoryId() ? 'selected' : '' ?>>
                    <?= $category->getName() ?></option>
                <?php
            }
            ?>
        </select>
    </div>

    <div class="col-12 mt-2">
        <select class="form-select" name="status" aria-label="Κατάσταση">
            <?php
            // Display the statuses options
            foreach ($statuses as $status) {
                ?>
                <option value="<?= $status->getId() ?>" <?= $status->getId() == $list->getStatusId() ? 'selected' : '' ?>>
                    <?= $status->getName() ?> </option>
                <?php
            }
            ?>
        </select>
    </div>

    <div class="col-12 mt-2">
        <button type="submit" class="form-control btn btn-primary">Ενημέρωση Λίστας
        </button>
    </div>
</form>
