/**
 * Display a message (error/success)
 *
 * @param message
 * @param errorType success/error
 */
const displayMessage = (message, errorType) => {
    const error = document.getElementById('error');
    const errorMessage = document.getElementsByClassName('errorMessage');

    error.classList.remove('d-none');

    // Display the error message
    errorMessage[0].innerHTML = message;

    // Add/remove classes based on error type
    if (errorType === 'success') {
        error.classList.add('alert-success');
        error.classList.remove('alert-danger');

        // Remove the success message after 5 seconds
        setTimeout(() => {
            error.classList.add('d-none');

            errorMessage[0].innerHTML = '';
            error.classList.remove('alert-success');
        }, 5000);
    } else {
        error.classList.add('alert-danger');
        error.classList.remove('alert-success');
    }
}

// Close the error message on close button click
document.addEventListener('DOMContentLoaded', function () {
    const closeButton = document.querySelector('#error .close');

    closeButton.addEventListener('click', function () {
        const error = document.getElementById('error');
        error.classList.add('d-none');
    });
});
