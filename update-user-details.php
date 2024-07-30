<?php
include('config/db_connect.php');

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id'];
    $full_name = filter_var($_POST['full_name'], FILTER_SANITIZE_STRING);
    $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $zip_code = filter_var($_POST['zip_code'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);

    // Validate data
    if (empty($full_name) || empty($country) || empty($address) || empty($city) || empty($zip_code) || empty($phone)) {
        $response['status'] = 'error';
        $response['message'] = 'All fields are required.';
        echo json_encode($response);
        exit;
    }

    // Check if user details already exist
    $query = "SELECT user_id FROM user_details WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update existing details
        $stmt->close();
        $query = "UPDATE user_details SET full_name = ?, country = ?, address = ?, city = ?, zip_code = ?, phone = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssi", $full_name, $country, $address, $city, $zip_code, $phone, $user_id);
    } else {
        // Insert new details
        $stmt->close();
        $query = "INSERT INTO user_details (user_id, full_name, country, address, city, zip_code, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssss", $user_id, $full_name, $country, $address, $city, $zip_code, $phone);
    }

    if ($stmt->execute()) {
        $response['status'] = 'success';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to save details.';
    }

    $stmt->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

$conn->close();
echo json_encode($response);
?>
