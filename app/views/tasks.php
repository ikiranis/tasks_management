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
        // The form to create a new task list
        const createListForm = document.getElementById('createListForm');

        // On createListForm submit, call the API to create a new task list
        createListForm.addEventListener('submit', function (e) {
            // Prevent the default form submit
            e.preventDefault();

            // Make the API call
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
                .then(response => {
                    // Get the response and check if it's ok
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.error);
                        });
                    }

                    // Return the success response
                    return response.json();
                })
                .then(data => {
                    // Do this on success
                    // console.log('Success: ', data.data);

                    // Display new tasks list component with the new data, at the top of the page
                    const tasksList = document.querySelector('.row');
                    tasksList.insertAdjacentHTML('afterbegin', data.HTMLComponent);
                })
                .catch(error => {
                    // Do this on error
                    console.error('Error: ', error);
                });
        });
    });

    /**
     * Add a task to a list
     *
     * @param id
     */
    const addTask = (id) => {
        const taskForm = document.getElementById('taskForm' + id);
        taskForm.classList.remove('d-none');

        // On createListForm submit, call the API to create a new task list
        taskForm.addEventListener('submit', function (e) {
            // Prevent the default form submit
            e.preventDefault();

            // Make the API call
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
                .then(response => {
                    // Get the response and check if it's ok
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.error);
                        });
                    }

                    // Return the success response
                    return response.json();
                })
                .then(data => {
                    // Do this on success

                    // Add new task to the tasks list component
                    const parentCard = taskForm.closest('.card');
                    const cardText = parentCard.querySelector('.card-text');

                    cardText.insertAdjacentHTML('beforeend', '<div>' + data.task.title + '</div>')
                })
                .catch(error => {
                    // Do this on error
                    console.error('Error: ', error);
                });

            taskForm.classList.add('d-none');
        });
    }
</script>
