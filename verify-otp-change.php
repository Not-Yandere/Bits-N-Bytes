<?php
session_start();
include('config/db_connect.php');

// Retrieve the OTP from the request
$data = json_decode(file_get_contents('php://input'), true);
$otp_input = $data['otp'];

if ($otp_input == $_SESSION['otp']) {
    // OTP is correct, update the email
    $new_email = $_SESSION['new_email'];
    $user_id = $_SESSION['id'];

    $query = "UPDATE bnb SET mail = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $new_email, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update email.']);
    }

    // Clear OTP session values
    unset($_SESSION['otp']);
    unset($_SESSION['new_email']);
} else {
    // OTP is incorrect
    echo json_encode(['status' => 'error', 'message' => 'Invalid OTP.']);
}
?>
