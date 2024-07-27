<?php
include('../config/db_connect.php');
$email_or_username = $password = '';
$mail = "false";
if (isset($_SESSION['admin-name']) && isset($_SESSION['admin-id'])) {
    header('Location: /dashboard');
    exit;
}

// Array to collect errors
$errors = array('mail' => '', 'password' => '');

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty(trim(htmlspecialchars($_POST['mail'])))) {
        $errors['mail'] = "Email / Username is required";
    } else {
        $email_or_username = trim(htmlspecialchars($_POST['mail']));
        if (filter_var($email_or_username, FILTER_VALIDATE_EMAIL)) {
            $mail = "true";
        } else {
            // Assume it's a username and validate against your regex
            if (!preg_match("/^[a-zA-Z0-9_.]{4,}$/", $email_or_username)) {
                $errors['mail'] = 'Please enter a valid Email / Username';
            }
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
            $query = "SELECT id, user, password FROM admin WHERE mail = '$email_or_username'";
        } else {
            $query = "SELECT id, user, password FROM admin WHERE user = '$email_or_username'";
        }

        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);
            // Verify the password
            if ($password == $row['password']) {
                // Start a session and save user data
                session_start();
                $_SESSION['admin-name'] = $row['user'];
                $_SESSION['admin-id'] = $row['id'];

                mysqli_free_result($result);
                mysqli_close($conn);

                header('Location: /dashboard');
                exit;
            } else {
                $errors['password'] = 'Invalid Email / Username or password';
            }
        } else {
            $errors['password'] = 'Invalid Email / Username or password';
        }
    }
}
?>
