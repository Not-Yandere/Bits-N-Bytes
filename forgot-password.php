<?php
require 'config/db_connect.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = $successMessage = '';

if (isset($_POST['submit'])) {
    if (empty(trim(htmlspecialchars($_POST['email'])))) {
        $error = "Email Address is required";
    } else {
        $email = trim(htmlspecialchars($_POST['email']));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid Email Address';
        } else {
            // Check if email exists in the database
            $result = mysqli_query($conn, "SELECT * FROM bnb WHERE mail='$email'");
            if (mysqli_num_rows($result) > 0) {
                $token = bin2hex(random_bytes(50)); // Generate a token
                $token_expiration = date('Y-m-d H:i:s', strtotime('+2 hours')); // Set token expiration

                mysqli_query($conn, "UPDATE bnb SET token='$token', token_expiration='$token_expiration' WHERE mail='$email'");

                $resetLink = "https://bitsnbytes.rf.gd/reset-password/$token";

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth = true;
                $mail->Username = 'booba.enjoyer69@gmail.com'; // SMTP username
                $mail->Password = 'knpuoqmhsctwjwdl'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('booba.enjoyer69@gmail.com', 'Bits N Bytes');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset';
                $mail->Body =  $mail->Body = "
                        <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                            <h2 style='color: #333;'>Password Reset Request</h2>
                            <p>Hello,</p>
                            <p>You have requested a password reset. Click the link below to reset your password:</p>
                            <p><a href='$resetLink' style='display: inline-block; padding: 10px 15px; background-color: #457B9D; color: #fff; text-decoration: none; border-radius: 5px; font-size: 14px;'>Reset Password</a></p>
                            <p>If you did not request this, please ignore this email.</p>
                            <p>Thank you,<br>Bits N Bytes Team</p>
                        </div>";

                if ($mail->send()) {
                    $successMessage = 'A password reset link has been sent to your email.<br> it might take 5 minutes to reach you !';
                    echo '<script>
                        setTimeout(function() {
                            window.location.href = "/log-in";
                        }, 3500);
                    </script>';
                } else {
                    $error = "Email could not be sent.";
                }
            } else {
                $error = "Email not found.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=0.8">
<link rel="stylesheet" href="CSS/log--in.css">
<link rel="shortcut icon" href="Images/icon.png">
<title>Forgot Password</title>
</head>
<body>
    <h1><a href="/">Bits N Bytes</a></h1>
    <div class="container">
    <h2>Password Reset</h2>
    <form action="/forgot-password" method="POST">
        <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>"  placeholder="Enter your email">
        <?php if ($successMessage): ?>
        <div class="successMessage" >
        &#10003; <?php echo $successMessage; ?>
        </div>
        <?php endif; ?>
        <div style="color: red;">
        <?php echo $error; ?>
        </div>
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>
    </div>
</body>
</html>
