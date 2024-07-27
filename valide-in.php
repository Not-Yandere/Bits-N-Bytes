<?php
// Include the function to establish a connection to the database
include('config/db_connect.php');

// Set variables to avoid errors
$email_or_username = $password = '';
$mail ="false";

// Array to collect errors
$errors = array('mail' => '', 'password' => '', 'captcha' => '');

// reCAPTCHA secret key
$recaptchaSecret = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Honeypot check
    $honeypot = $_POST['honeypot'];
    if (!empty($honeypot)) {
        exit('No bots allowed!');
    }

    // Verify reCAPTCHA
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        $errors['captcha'] = 'Please complete the CAPTCHA!';
    }

    // Check if email/username is not empty and sanitize input
    if (empty(trim(htmlspecialchars($_POST['mail'])))) {
        $errors['mail'] = "Email / Username is required";
    } else {
        $email_or_username = trim(htmlspecialchars($_POST['mail']));
        // Check if it's an email
        if (filter_var($email_or_username, FILTER_VALIDATE_EMAIL)) {
            // Validate email format
            $mail = "true";
        } else {
            // Assume it's a username and validate against your regex
            if (!preg_match("/^[a-zA-Z0-9_.]{4,}$/", $email_or_username)) {
                $errors['mail'] = 'Please enter a valid Email / Username';
            }
            // You may add further checks here for username format if needed
        }
    }

    // Check if password is not empty and sanitize input
    if (empty(trim(htmlspecialchars($_POST['password'])))) {
        $errors['password'] = "Password is required";
    } else {
        $password = trim(htmlspecialchars($_POST['password']));
        if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password)) {
            $errors['password'] = 'Please enter a valid Password';
        }
    }

    // Check if there are no errors
    if (!array_filter($errors)) {
        // Sanitize email/username and password
        $email_or_username = mysqli_real_escape_string($conn, $email_or_username);
        $password = mysqli_real_escape_string($conn, $password);

        // Query the database based on whether it's email or username
        if ($mail == "true") {
            $query = "SELECT id, user, password FROM bnb WHERE mail = '$email_or_username'";
        } else {
            $query = "SELECT id, user, password FROM bnb WHERE user = '$email_or_username'";
        }

        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);
            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Start a session and save user data
                $_SESSION['user'] = $row['user'];
                $_SESSION['id'] = $row['id'];

                if (isset($_POST['remember_me'])) {
                    $token = bin2hex(random_bytes(16));
                    $expiry = date('Y-m-d H:i:s', time() + (86400 * 7));
                    $query = "UPDATE bnb SET login_token = ?, login_token_expiration = ? WHERE id = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, 'ssi', $token, $expiry, $row['id']);
                    mysqli_stmt_execute($stmt);
                    setcookie('remember_me', $token, time() + (86400 * 7), "/", "", true, true);
                }

                mysqli_free_result($result);
                mysqli_close($conn);

                header('Location: /');
            } else {
                $errors['password'] = 'Invalid Email / Username or password';
            }
        } else {
            $errors['password'] = 'Invalid Email / Username or password';
        }
    }
}
?>
