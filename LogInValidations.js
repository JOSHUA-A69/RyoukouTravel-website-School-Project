document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('.login_form');
    const emailInput = document.getElementById('login_email');
    const passwordInput = document.getElementById('login_password');

    loginForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission

        // Clear all previous error messages
        clearErrorMessages();

        // Validate the form
        if (validateLoginForm()) {
            // Redirect to main page after successful login
            window.location.href = 'Blog.html';
        } else {
            // Display general error message
            showError('Login failed. Please check your credentials.', 'login-error');
        }
    });

    function validateLoginForm() {
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

        let isValid = true;

        // Validate email
        if (email === '' || !isValidEmail(email)) {
            showError('Please enter a valid email address.', 'login-email-error');
            isValid = false;
        }

        // Validate password
        if (password === '') {
            showError('Please enter your password.', 'login-password-error');
            isValid = false;
        } else if (password.length < 8) {
            showError('Password should be at least 8 characters long.', 'login-password-error');
            isValid = false;
        }
        
        return isValid;
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
