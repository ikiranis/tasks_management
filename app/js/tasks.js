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
    // Get the form to add a new task. Every form has a unique id, based on tasksListId
    const taskForm = document.getElementById('taskForm' + id);
    // Remove the d-none class to display the form
    taskForm.classList.remove('d-none');

    // Check if submit event listener has been added
    // Prevent adding the same event listener multiple times
    if (taskForm.hasAttribute('data-event-listener-added')) {
        return
    }

    // On taskForm submit, call the API to create a new task list
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

                // Clean form data
                this.reset();

                // Add new task to the tasks list
                const parentCard = taskForm.closest('.card');
                const cardText = parentCard.querySelector('.card-text');
                const emptyTasks = parentCard.querySelector('.emptyTasks');

                // Remove the empty list message, if it exists
                if (emptyTasks) {
                    emptyTasks.remove();
                }

                // Display the new task
                cardText.insertAdjacentHTML('beforeend', data.HTMLComponent);
            })
            .catch(error => {
                // Do this on error
                console.error('Error: ', error);
            });

        taskForm.classList.add('d-none');
    });

    // Add a custom attribute to the form to indicate that an event listener has been added
    taskForm.setAttribute('data-event-listener-added', 'true');
}

/**
 * Delete a task
 *
 * @param id
 */
const deleteTask = (id) => {
    // Create formData object from json
    const formData = new FormData();
    formData.append('taskId', id);

    // Make the API call
    fetch('api/deleteTask', {
        method: 'POST',
        body: formData
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

            // Remove the task from the tasks list
            const task = document.getElementById('task' + id);
            task.remove();
        })
        .catch(error => {
            // Do this on error
            console.error('Error: ', error);
        });
}

/**
 * Delete a tasks list
 *
 * @param id
 */
const deleteTasksList = (id) => {
    // display alert to delete
    if (!confirm('Είσαι σίγουρος ότι θέλεις να σβήσεις αυτή την λίστα;')) {
        return;
    }

    // Create formData object from json
    const formData = new FormData();
    formData.append('tasksListId', id);

    // Make the API call
    fetch('api/deleteTasksList', {
        method: 'POST',
        body: formData
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

            // Remove the task from the tasks list
            const tasksList = document.getElementById('tasksList' + id);
            tasksList.remove();
        })
        .catch(error => {
            // Do this on error
            console.error('Error: ', error);
        });
}

/**
 * Edit a tasks list
 *
 * @param id
 */
const editTasksList = (id) => {
    // Create formData object from json
    const formData = new FormData();
    formData.append('taskId', id);

    // Make the API call
    fetch('api/deleteTask', {
        method: 'POST',
        body: formData
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

            // Remove the task from the tasks list
            const task = document.getElementById('task' + id);
            task.remove();
        })
        .catch(error => {
            // Do this on error
            console.error('Error: ', error);
        });
}
