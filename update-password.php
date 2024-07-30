<?php
include('config/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $current_password = filter_var($input['current_password'], FILTER_SANITIZE_STRING);
    $new_password = filter_var($input['new_password'], FILTER_SANITIZE_STRING);
    $user_id = $_SESSION['id'];

    // Fetch current password hash from the database
    $query = "SELECT password FROM bnb WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (password_verify($current_password, $user['password'])) {
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $query = "UPDATE bnb SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $new_password_hashed, $user_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update password']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect']);
    }
}
?>
