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
include('config/db_connect.php');
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

// Input validation and sanitation
$input = json_decode(file_get_contents('php://input'), true);
$email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
    exit();
}

// Check if the email already exists
$stmt = $conn->prepare("SELECT id FROM bnb WHERE mail = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email already in use.']);
    exit();
}

// Generate OTP
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['new_email'] = $email;

try {
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
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP Code';
    $mail->Body = "
        <div style='font-family: Arial, sans-serif; line-height: 1.5;'>
            <h2 style='color: #333;'>Your OTP Code</h2>
            <p>Dear user,</p>
            <p>Your OTP code is:</p>
            <p style='font-size: 20px; font-weight: bold; color: #000;'>{$otp}</p>
            <p>Please enter this code in the verification form to complete your email update.</p>
            <p>Regards,<br>Bits N Bytes</p>
        </div>
    ";

    $mail->send();
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
}
?>
