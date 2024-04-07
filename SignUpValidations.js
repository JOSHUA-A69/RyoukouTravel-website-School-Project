document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('signup_form');
    const fullname = document.getElementById('fullname');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevents form submission

        // Clear all previous error messages
        clearErrorMessages();

        // Validate the form
        if (validateForm()) {
            // Redirect to main page here
            window.location.href = 'Blog.html';
        } else {
            // Display general error message
            showError('Form validation failed');
        }
    });

    function validateForm() {
        let isValid = true;

        // Validate full name
        if (fullname.value.trim() === '') {
            showError('Please enter your full name', 'fullname-error');
            isValid = false;
        } else if (!isValidFullName(fullname.value)) {
            showError('Full name should only contain letters, spaces, and periods', 'fullname-error');
            isValid = false;
        }

        // Validate email
        if (email.value.trim() === '') {
            showError('Please enter your email address', 'email-error');
            isValid = false;
        } else if (!isValidEmail(email.value)) {
            showError('Please enter a valid email address', 'email-error');
            isValid = false;
        }

        // Validate password
        if (password.value === '') {
            showError('Please enter your password', 'password-error');
            isValid = false;
        } else if (password.value.length < 8) {
            showError('Password should be at least 8 characters long', 'password-error');
            isValid = false;
        }

        // Validate confirm password
        if (confirmPassword.value === '') {
            showError('Please confirm your password', 'confirm-password-error');
            isValid = false;
        } else if (password.value !== confirmPassword.value) {
            showError('Password confirmation does not match', 'confirm-password-error');
            isValid = false;
        }

        return isValid;
    }

    function isValidFullName(value) {
        // Check if the value contains only letters, spaces, and periods
        return /^[a-zA-Z\s.]+$/.test(value);
    }

    function isValidEmail(value) {
        // Simple email validation (checking for @ symbol)
        return value.includes('@');
    }

    function showError(message, errorId) {
        const errorElement = document.getElementById(errorId);
        errorElement.textContent = message;
    }

    function clearErrorMessages() {
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(message => {
            message.textContent = '';
        });
    }
});
