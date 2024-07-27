<?php
include 'config/db_connect.php';

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$cart = $data['cart'];

// Start a transaction
mysqli_begin_transaction($conn);

try {
    foreach ($cart as $cartItem) {
        $itemId = $cartItem['id'];
        $quantity = $cartItem['quantity'];

        // Decrease the quantity of the item in the database
        $query = "UPDATE items SET Quantity = Quantity - ? WHERE ItemId = ? AND Quantity >= ?";
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'iii', $quantity, $itemId, $quantity);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt) == 0) {
                throw new Exception("Insufficient stock for item ID: $itemId");
            }
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception("Failed to prepare statement for item ID: $itemId");
        }
    }

    // Commit the transaction
    mysqli_commit($conn);

    // Return a response
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    // Roll back the transaction in case of an error
    mysqli_rollback($conn);

    // Return an error response
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

mysqli_close($conn);
?>
