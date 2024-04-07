document.addEventListener('DOMContentLoaded', function () {
    // The form to create a new team
    const createTeamForm = document.getElementById('createTeamForm');

    // On createTeamForm submit, call the API to create a new team
    createTeamForm.addEventListener('submit', function (e) {
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
                        throw new Error(err.message);
                    });
                }

                this.reset()

                // Return the success response
                return response.json();
            })
            .then(data => {
                // Do this on success

                // Display new team component with the new data, at the top of the page
                const team = document.querySelector('.row');
                team.insertAdjacentHTML('beforeend', data.HTMLComponent);

                displayMessage("Η ομάδα δημιουργήθηκε επιτυχώς", 'success');
            })
            .catch(error => {
                // Do this on error
                displayMessage(error, 'error');
            });
    });

    // The form to export data from teams to XML
    const exportTeamsToXMLForm = document.getElementById('exportTeamsToXMLForm');

    // On exportTeamsToXMLForm submit, call the API to get the XML file
    exportTeamsToXMLForm.addEventListener('submit', function (e) {
        // Prevent the default form submit
        e.preventDefault();

        // Make the API call
        fetch(this.action, {
            method: 'GET'
        })
            .then(response => {
                // Get the response and check if it's ok
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message);
                    });
                }

                // Return the success response
                return response.json();
            })
            .then(data => {
                // Do this on success

                // Export xml to file
                exportXMLToFile(data.xml);

                displayMessage('To XML δημιουργήθηκε', 'success');
            })
            .catch(error => {
                // Do this on error
                displayMessage(error, 'error');
            });
    });
});

/**
 * Export data to file
 *
 * @param data
 */
const exportXMLToFile = (data) => {
    const blob = new Blob([data], {type: 'application/xml'});
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'teams.xml';
    a.click();
    window.URL.revokeObjectURL(url);
}

/**
 * Add a user to a team
 *
 * @param teamId
 */
const addUserToTeam = (teamId) => {
    // Get the form to add a user. Every form has a unique id, based on the team id
    const addUserForm = document.getElementById('addUserForm' + teamId);

    // Make the API call
    fetch(addUserForm.action, {
        method: 'POST',
        body: new FormData(addUserForm)
    })
        .then(response => {
            // Get the response and check if it's ok
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message);
                });
            }

            // Return the success response
            return response.json();
        })
        .then(data => {
            // Do this on success

            // Add the new user to the list of users in the team
            const usersInTeam = document.getElementById('usersInTeam' + teamId);
            usersInTeam.insertAdjacentHTML('beforeend', data.HTMLComponent);

            // Add the new user to the list of users in the addUserToListForm
            const addUserToListForm = document.getElementById('addUserToListForm' + teamId);
            const select = addUserToListForm.querySelector('#user');
            const option = document.createElement('option');

            option.value = data.user.id;
            option.text = data.user.username;

            select.appendChild(option);

            displayMessage("Ο χρήστης προστέθηκε επιτυχώς στην ομάδα", 'success');
        })
        .catch(error => {
            // Do this on error
            displayMessage(error, 'error');
        });
}

/**
 * Add a user to a list
 *
 * @param teamId
 */
const addUserToList = (teamId) => {
    // Get the form to add a user to a list. Every form has a unique id, based on the team id
    const addUserToListForm = document.getElementById('addUserToListForm' + teamId);

    // Check if user selected is empty
    const userSelected = addUserToListForm.querySelector('#user');

    if (!userSelected.value) {
        displayMessage("Πρέπει να επιλέξεις έναν χρήστη", 'error');
        return;
    }

    // Make the API call
    fetch(addUserToListForm.action, {
        method: 'POST',
        body: new FormData(addUserToListForm)
    })
        .then(response => {
            // Get the response and check if it's ok
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message);
                });
            }

            // Return the success response
            return response.json();
        })
        .then(data => {
            // Do this on success

            displayMessage("Ο χρήστης προστέθηκε επιτυχώς στην λίστα", 'success');
        })
        .catch(error => {
            // Do this on error
            displayMessage(error, 'error');
        });
}
