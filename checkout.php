<?php
include 'config/db_connect.php';

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$cart = $data['cart'];
$user_id = $_SESSION['id']; // Assuming you have the user ID stored in the session

// Start a transaction
mysqli_begin_transaction($conn);

try {
    // Insert into orders table
    $total_price = 0;
    foreach ($cart as $cartItem) {
        $itemId = $cartItem['id'];
        $quantity = $cartItem['quantity'];
        $query = "SELECT Price FROM items WHERE ItemId = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $itemId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $item = mysqli_fetch_assoc($result);
        $price = floatval(preg_replace('/[^\d.]/', '', $item['Price']));
        $total_price += $price * $quantity;
        mysqli_stmt_close($stmt);
    }
    
    $query = "INSERT INTO orders (user_id, order_date, total_price) VALUES (?, NOW(), ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'id', $user_id, $total_price);
    mysqli_stmt_execute($stmt);
    $order_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    foreach ($cart as $cartItem) {
        $itemId = $cartItem['id'];
        $quantity = $cartItem['quantity'];
        $query = "SELECT Price FROM items WHERE ItemId = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $itemId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $item = mysqli_fetch_assoc($result);
        $price = floatval(preg_replace('/[^\d.]/', '', $item['Price']));
        mysqli_stmt_close($stmt);

        // Insert into order_items table
        $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'iiid', $order_id, $itemId, $quantity, $price);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

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
