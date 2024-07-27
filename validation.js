function validateLoginForm() {
    var mail = document.getElementById('mail').value;
    var password = document.getElementById('password').value;
    var usernamePattern = /^[a-zA-Z0-9_.]{4,}$/;
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    var passwordPattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;

    var hasError = false;

    // Clear previous error messages
    document.getElementById('error-mail').innerText = '';
    document.getElementById('error-password').innerText = '';

    if (mail === '') {
        document.getElementById('error-mail').innerText = 'Email / Username is required.';
        hasError = true;
    } else if (!mail.match(emailPattern) && !mail.match(usernamePattern)) {
        document.getElementById('error-mail').innerText = 'Please enter a valid Email / Username.';
        hasError = true;
    }

    if (password === '') {
        document.getElementById('error-password').innerText = 'Password is required.';
        hasError = true;
    } else if (!password.match(passwordPattern)) {
        document.getElementById('error-password').innerText = 'Please Enter A valid Password.';
        hasError = true;
    }

    return !hasError;
}

function validateSignupForm() {
    var user = document.getElementById('user').value;
    var mail = document.getElementById('mail').value;
    var password = document.getElementById('password').value;
    var usernamePattern = /^[a-zA-Z0-9_.]{4,}$/;
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    var passwordPattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;

    var hasError = false;

    // Clear previous error messages
    document.getElementById('error-user').innerText = '';
    document.getElementById('error-mail').innerText = '';
    document.getElementById('error-password').innerText = '';

    if (user === '') {
        document.getElementById('error-user').innerText = 'Username is required.';
        hasError = true;
    } else if (!user.match(usernamePattern)) {
        document.getElementById('error-user').innerText = 'The username must be at least 4 characters long and can only contain letters, numbers, underscores, and dots.';
        hasError = true;
    }

    if (mail === '') {
        document.getElementById('error-mail').innerText = 'Email is required.';
        hasError = true;
    } else if (!mail.match(emailPattern)) {
        document.getElementById('error-mail').innerText = 'Please enter a valid email address.';
        hasError = true;
    }

    if (password === '') {
        document.getElementById('error-password').innerText = 'Password is required.';
        hasError = true;
    } else if (!password.match(passwordPattern)) {
        document.getElementById('error-password').innerText = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
        hasError = true;
    }

    return !hasError;
}