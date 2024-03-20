document.addEventListener('DOMContentLoaded', function () {
    const registerUserForm = document.getElementById('registerUserForm');

    // On registerUserForm submit check for form validation
    registerUserForm.addEventListener('submit', async function (e) {
        // Prevent the default form submit
        e.preventDefault();

        clearErrorTexts();

        // Check for form validation.
        // Using await, because checkForUsernameExistence is an async function, with API call.
        // So we need to wait for the response before we continue
        if (await validateForm()) {
            // Form is valid, submit it
            registerUserForm.submit();
        } else {
            // Form is not valid, display an error message
            displayMessage('Please fill in the form correctly', 'error');
        }
    });
});

/**
 * Check for form validation
 *
 * @returns {boolean}
 */
const validateForm = async () => {
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('verify_password');
    const email = document.getElementById('email');
    const name = document.getElementById('name');

    let valid = true;

    if (!username.checkValidity()) {
        const usernameError = document.getElementById('usernameError');
        usernameError.classList.remove('d-none');
        usernameError.innerText = 'Παρακαλώ εισάγετε ένα έγκυρο όνομα χρήστη';

        valid = false;
    }

    // Need to get asynchronously the API call response
    const exists = await checkForUsernameExistence(username.value)
    if (exists) {
        const usernameError = document.getElementById('usernameError');
        usernameError.classList.remove('d-none');
        usernameError.innerText = 'Το όνομα χρήστη υπάρχει ήδη';

        valid = false;
    }

    if (!password.checkValidity()) {
        const passwordError = document.getElementById('passwordError');
        passwordError.classList.remove('d-none');
        passwordError.innerText = 'Παρακαλώ εισάγετε έναν έγκυρο κωδικό';

        valid = false;
    }

    if (!email.checkValidity()) {
        const emailError = document.getElementById('emailError');
        emailError.classList.remove('d-none');
        emailError.innerText = 'Παρακαλώ εισάγετε μία έγκυρη διεύθυνση email';

        valid = false;
    }

    if (!name.checkValidity()) {
        const nameError = document.getElementById('nameError');
        nameError.classList.remove('d-none');
        nameError.innerText = 'Παρακαλώ εισάγετε το όνομά σας';

        valid = false;
    }

    // Check if the passwords match
    if (password.value !== confirmPassword.value) {
        const verifyPasswordError = document.getElementById('verifyPasswordError');
        verifyPasswordError.classList.remove('d-none');
        verifyPasswordError.innerText = 'Ο κωδικός επιβεβαίωσης δεν ταιριάζει';

        valid = false;
    }

    return valid;
}

/**
 * Hide all error texts
 */
const clearErrorTexts = () => {
    const usernameError = document.getElementById('usernameError');
    const passwordError = document.getElementById('passwordError');
    const emailError = document.getElementById('emailError');
    const verifyPasswordError = document.getElementById('verifyPasswordError');
    const nameError = document.getElementById('nameError');

    usernameError.classList.add('d-none');
    passwordError.classList.add('d-none');
    emailError.classList.add('d-none');
    verifyPasswordError.classList.add('d-none');
    nameError.classList.add('d-none');
}

/**
 * Check if a username exists in the database
 * Async function, because it makes an API call
 * Returns a promise
 *
 * @param username
 */
const checkForUsernameExistence = async (username) => {
    return fetch('api/checkUsername?username=' + username, {
        method: 'GET'
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message);
                });
            }

            return response.json();
        })
        .then(data => data.exists)
        .catch(error => {
            displayMessage(error, 'error');
        });
}
