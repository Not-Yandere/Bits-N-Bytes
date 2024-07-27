<?php
// Include the validation function in signing up and adding data to db
include 'valide-up.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <link rel="stylesheet" href="CSS/log--in.css">
    <link rel="shortcut icon" href="Images/icon.png">
    <title>Sign Up</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="validation.js"></script>
</head>
<body>
    <h1><a href="/">Bits N Bytes</a></h1>
    <div class="container">
        <h2>Sign up</h2>
        <form class="Log-in-form buyer" id="buyer" action="/sign-up" method="POST" style="display: block;" onsubmit="return validateSignupForm()">
            <label for="user">Username:</label>
            <input type="text" id="user" name="user" placeholder="UserName" value="<?php echo htmlspecialchars($user); ?>">
            <div style="color: red;" id="error-user">
                <?php echo $errors['user']; ?>
            </div>
            <label for="mail">Email:</label>
            <input type="text" id="mail" name="mail" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
            <div style="color: red;" id="error-mail">
                <?php echo $errors['mail']; ?>
            </div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password">
            <div style="color: red;" id="error-password">
                <?php echo $errors['password']; ?>
            </div>
            
            <input type="text" name="honeypot" style="display:none;">
            
            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
            <div class="captcha-error">
                <?php echo $errors['captcha']; ?>
            </div>

            <p>By continuing, you agree to our <a href="/terms-of-service">Terms of Services</a> and <a href="/privacy-policy">Privacy Policy</a>.</p>
            <button type="submit" name="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="/log-in">Log in now!</a></p>
    </div>
</body>
</html>
