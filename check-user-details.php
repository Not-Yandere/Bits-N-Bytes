<?php
include 'config/db_connect.php';
$user_id = $_SESSION['id'];
$query = "SELECT * FROM user_details WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['user_status'] = 'incomplete';
    echo json_encode(['status' => 'incomplete']);
} else {
    echo json_encode(['status' => 'complete']);
}
$stmt->close();
?>
