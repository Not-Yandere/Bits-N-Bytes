<?php
include 'config/db_connect.php';

// Set the content type to JSON to avoid any misinterpretation
header('Content-Type: application/json');

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Initialize response
$response = [];

if (isset($data['cart']) && !empty($data['cart'])) {
    $cart = $data['cart'];
    $itemIds = implode(',', array_map('intval', $cart));
    $sql = "SELECT * FROM items WHERE ItemId IN ($itemIds)";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }
        mysqli_free_result($result);
    } else {
        // Log SQL error
        $response = ['error' => 'SQL query failed: ' . mysqli_error($conn)];
    }
} else {
    $response = ['error' => 'Invalid cart data'];
}

mysqli_close($conn);

// Return the response as JSON
echo json_encode($response);
?>
