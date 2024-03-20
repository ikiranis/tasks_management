document.addEventListener('DOMContentLoaded', function () {
    const registerUserForm = document.getElementById('registerUserForm');

    registerUserForm.addEventListener('submit', function (e) {
        // Prevent the default form submit
        e.preventDefault();

        clearErrorTexts();

        if (validateForm()) {
            registerUserForm.submit();
        } else {
            displayMessage('Please fill in the form correctly', 'error');
        }
    });
});

/**
 * Check for form validation
 *
 * @returns {boolean}
 */
const validateForm = () => {
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('verify_password');
    const email = document.getElementById('email');
    const name = document.getElementById('name');

    let valid = true;

    if (!username.checkValidity()) {
        const usernameError = document.getElementById('usernameError');
        usernameError.classList.remove('d-none');
        usernameError.innerText = 'Please enter a valid username';

        valid = false;
    }

    if (!checkForUsernameExistence(username.value)) {
        const usernameError = document.getElementById('usernameError');
        usernameError.classList.remove('d-none');
        usernameError.innerText = 'Username already exists';

        valid = false;
    }

    if (!password.checkValidity()) {
        const passwordError = document.getElementById('passwordError');
        passwordError.classList.remove('d-none');
        passwordError.innerText = 'Please enter a valid password';

        valid = false;
    }

    if (!email.checkValidity()) {
        const emailError = document.getElementById('emailError');
        emailError.classList.remove('d-none');
        emailError.innerText = 'Please enter a valid email';

        valid = false;
    }

    // Check if the passwords match
    if (password.value !== confirmPassword.value) {
        const verifyPasswordError = document.getElementById('verifyPasswordError');
        verifyPasswordError.classList.remove('d-none');
        verifyPasswordError.innerText = 'Passwords do not match';

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
 *
 * @param username
 */
const checkForUsernameExistence = (username) => {

    fetch('api/checkUsername?username=' + username, {
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
        .then(data => {
            return !!data.exists;
        })
        .catch(error => {
            displayMessage(error, 'error');
        });

    return false;
}
