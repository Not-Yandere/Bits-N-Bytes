<?php
if (!function_exists('loadEnv')) {
    function loadEnv($file) {
        $vars = parse_ini_file($file, true);
        foreach ($vars as $key => $value) {
            $_ENV[$key] = $value;
        }
    }
}
loadEnv(__DIR__ . '/config/yandere.env');
// File that has function to establish connection to db
include('config/db_connect.php');

// Include PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// // Set variables to nothing to avoid errors
$user = $email = $password = '';

// Array to collect errors
$errors = array('user'=>'', 'mail'=>'', 'password'=>'', 'captcha'=>'');

// reCAPTCHA secret key
$recaptchaSecret = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check honeypot
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

    // Check if button is pressed and data is saved to add to db
    if (isset($_POST['submit'])) {
        // Check if username is not empty and sanitize input
        if (empty(trim(htmlspecialchars($_POST['user'])))) {
            $errors['user'] = "UserName is required";
        } else {
            $user = trim(htmlspecialchars($_POST['user']));
            if (!preg_match('/^[a-zA-Z0-9_.]{4,}$/', $user)) {
                $errors['user'] = 'The username must be at least 4 characters long and can only contain letters, numbers, underscores, and dots.';
            } else {
                $checkUserResult = mysqli_query($conn, "SELECT * FROM bnb WHERE user = '$user'");
                if (mysqli_num_rows($checkUserResult) > 0) {
                    $errors['user'] = 'This username is already taken';
                }
                mysqli_free_result($checkUserResult);
            }
        }

        // Check if email is not empty and sanitize input
        if (empty(trim(htmlspecialchars($_POST['mail'])))) {
            $errors['mail'] = "Email is required";
        } else {
            $email = trim(htmlspecialchars($_POST['mail']));
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['mail'] = 'Please enter a valid Email Address';
            } else {
                $checkEmailResult = mysqli_query($conn, "SELECT * FROM bnb WHERE mail = '$email'");
                if (mysqli_num_rows($checkEmailResult) > 0) {
                    $errors['mail'] = 'This email is already registered';
                }
                mysqli_free_result($checkEmailResult);
            }
        }

        // Check if password is not empty and sanitize input
        if (empty(trim(htmlspecialchars($_POST['password'])))) {
            $errors['password'] = "Password is required";
        } else {
            $password = trim(htmlspecialchars($_POST['password']));
            if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password)) {
                $errors['password'] = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
            }
        }

        if (!array_filter($errors)) {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Store OTP and user data in session
            session_start();
            $_SESSION['user1'] = $user;
            $_SESSION['email1'] = $email;
            $_SESSION['password1'] = $password;
            $_SESSION['otp'] = $otp;


            //Send OTP to user's email using PHPMailer
            $mail = new PHPMailer(true);
            
                // Server settings
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth = filter_var($_ENV['SMTP_AUTH'], FILTER_VALIDATE_BOOLEAN);
                $mail->Username = $_ENV['SMTP_USERNAME'];
                $mail->Password = $_ENV['SMTP_PASSWORD'];
                $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
                $mail->Port = $_ENV['SMTP_PORT'];

                // Recipients
                $mail->setFrom($_ENV['SMTP_USERNAME'], 'Bits N Bytes');
                $mail->addAddress($email, $user);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body = "
                <div style='font-family: Arial, sans-serif; line-height: 1.5;'>
                <h2 style='color: #333;'>Your OTP Code</h2>
                <p>Dear {$_SESSION['user1']},</p>
                <p>Thank you for registering. Your OTP code is:</p>
                <p style='font-size: 20px; font-weight: bold; color: #000;'>{$otp}</p>
                <p>Please enter this code in the verification form to complete your registration.</p>
                <p>Regards,<br>Bits N Bytes</p>
                </div>
        ";

                $mail->send();
                // Redirect to OTP verification page
                header('Location: /verify-otp');
                exit();
            
            
        }
    }
}
?>
