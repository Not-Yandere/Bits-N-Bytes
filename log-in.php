<?php
// Include the validation function in logging in
include 'session_check.php';
include 'valide-in.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <link rel="stylesheet" href="CSS/log--in.css">
    <link rel="shortcut icon" href="Images/icon.png">
    <title>Log In</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="validation.js"></script>
</head>  
<body>
    <h1><a href="/">Bits N Bytes</a></h1>
    <div class="container">
        <h2>Log In</h2>
        <!-- using POST method for better security -->
        <form class="Log-in-form buyer" id="buyer" action="/log-in" method="POST" style="display: block;" onsubmit="return validateLoginForm()">
            <label for="mail">Email / Username:</label>
            <!-- the input is not deleted if error occur by storing input in a variable then use it as default value -->
            <input type="text" id="mail" name="mail" placeholder="Email / Username" value="<?php echo htmlspecialchars($email_or_username); ?>">
            <!-- error message -->
            <div style="color: red;" id="error-mail">
                <?php echo $errors['mail']; ?>
            </div>
            <label for="password">Password:</label>
            <!-- the input is not deleted if error occur by storing input in a variable then use it as default value -->
            <input type="password" id="password" name="password" placeholder="Password">
            <!-- error message -->
            <div style="color: red;" id="error-password">
                <?php echo $errors['password']; ?>
            </div>
            <label for="remember_me"><input type="checkbox" id="remember_me" name="remember_me"> Remember Me</label>
            <div style="margin-left: 5px;">
            <p><a href="/forgot-password" >Forgot Password?</a></p>
            </div>
            <!-- Honeypot field (hidden from users) -->
            <input type="text" name="honeypot" style="display:none;">
            
            <!-- CAPTCHA -->
            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
            <div class="captcha-error">
                <?php echo $errors['captcha']; ?>
            </div>
            <p>By continuing, you agree to our <a href="/terms-of-service">Terms of Services</a> and <a href="/privacy-policy">Privacy Policy</a>.</p>
            <button type="submit" name="submit">Log In</button>
        </form>
        <p>Don't have an account? <a href="/sign-up">Sign up now!</a></p>
        
    </div>
</body>
</html>
