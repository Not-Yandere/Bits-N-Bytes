<?php
require 'config/db_connect.php';

$error = $successMessage = '';

if (isset($_POST['submit'])) {
    $token = $_POST['token'];
    $newPassword = trim(htmlspecialchars($_POST['new_password']));
    $confirmPassword = trim(htmlspecialchars($_POST['confirm_password']));

    // Check if token is valid and not expired
    $query = "SELECT * FROM bnb WHERE token='$token'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $currentPasswordHash = $user['password'];
        $tokenExpiration = $user['token_expiration'];

        // Check if the token is expired
        if (strtotime($tokenExpiration) < time()) {
            $error = "The token has expired. Please request a new password reset.";
        } else {
            // Validate new password
            if (empty($newPassword)) {
                $error = "Password is required";
            } elseif (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $newPassword)) {
                $error = '<em>A minimum 8 characters password contains a combination of: a <strong>uppercase</strong> & a <strong>lowercase letter</strong> & a <strong>number</strong> & a <strong>special character</strong> (#?!@$%^&*-)</em>';
            } elseif (password_verify($newPassword, $currentPasswordHash)) {
                $error = "New password cannot be the same as the old password.";
            } elseif ($newPassword != $confirmPassword) {
                $error = "Passwords do not match.";
            } else {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password and clear the token
                $query = "UPDATE bnb SET password='$hashedPassword', token=NULL, token_expiration=NULL WHERE token='$token'";
                if (mysqli_query($conn, $query)) {
                    $successMessage = "Your password has been reset successfully.";
                    echo '<script>
                        setTimeout(function() {
                            window.location.href = "/log-in";
                        }, 2500);
                    </script>';
                } else {
                    $error = "Error updating password.";
                }
            }
        }
    } else {
        $error = "Invalid or expired token.";
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    $error = "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <link rel="stylesheet" href="CSS/log--in.css">
    <link rel="shortcut icon" href="Images/icon.png">
    <title>Reset Password</title>
</head>
<body>
    <h1><a href="/">Bits N Bytes</a></h1>
    <div class="container">
    <h2>Password Reset</h2>
    <form action="/reset-password" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <input type="password" name="new_password" placeholder="Enter new password" required>
        <input type="password" name="confirm_password" placeholder="Confirm new password" required>
        <?php if ($successMessage): ?>
        <div class="successMessage">
        &#10003; <?php echo $successMessage; ?>
        </div>
        <?php endif; ?>
        <div style="color: red;">
        <?php echo $error; ?>
        </div>
        <br>
        <button type="submit" name="submit">Reset Password</button>
    </form>
    </div>
</body>
</html>
