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
                <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                    <div class="card">
                        <div class="card-header">
                            <strong>Δημιουργία του site</strong>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div>Υλοποίηση του frontend</div>
                                <div>Υλοποίηση του backend</div>
                                <div>Σύνδεση frontend με backend</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                    <div class="card">
                        <div class="card-header">
                            <strong>Συντήρηση του site</strong>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div>Επιδιόρθωση σφαλμάτων</div>
                                <div>Προσθήκη νέων λειτουργιών</div>
                                <div>Ενημέρωση του backend</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form id="createListForm" action="api/createTasksList" method="POST" class="mt-5 row">
                <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                    <input type="text" class="form-control" placeholder="Τίτλος Λίστας" name="title"
                           aria-label="Τίτλος Λίστας">
                </div>

                <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                    <select class="form-select" name="category" aria-label="Κατηγορία">
                        <option selected value="1">Κατηγορία 1</option>
                        <option value="2">Κατηγορία 2</option>
                        <option value="3">Κατηγορία 3</option>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const createListForm = document.getElementById('createListForm');

        createListForm.addEventListener('submit', function (e) {
            e.preventDefault();

            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.error);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success: ', data);
                })
                .catch(error => {
                    console.error('Error: ', error);
                });
        });
    });
</script>
