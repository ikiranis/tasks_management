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
