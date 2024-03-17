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
                        throw new Error(err.error);
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
                team.insertAdjacentHTML('afterbegin', data.HTMLComponent);
            })
            .catch(error => {
                // Do this on error
                console.error('Error: ', error);
            });
    });
});

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
                    throw new Error(err.error);
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
        })
        .catch(error => {
            // Do this on error
            console.error('Error: ', error);
        });
}
