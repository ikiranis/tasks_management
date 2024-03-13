<form id="editListForm<?= $list->getId() ?>" action="api/updateTasksList" method="post"
      class="bg-light d-none position-absolute">
    <div class="col-12 col-lg-6 mt-2 mt-lg-0">
        <input type="text" class="form-control" placeholder="Τίτλος Λίστας" name="title" value="<?= $list->getTitle() ?>"
               aria-label="Τίτλος Λίστας">
    </div>

    <input type="hidden" name="tasksListId" value="<?= $list->getId() ?>">

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
        <button type="submit" class="form-control btn btn-primary">Ενημέρωση Λίστας
        </button>
    </div>
</form>
