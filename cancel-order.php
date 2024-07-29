<?php
include 'config/db_connect.php';


$user_id = $_SESSION['id'];
$input = file_get_contents('php://input');
$data = json_decode($input, true);
$order_id = $data['order_id'];

// Start a transaction
mysqli_begin_transaction($conn);

try {
    // Check if the order belongs to the logged-in user and is not already delivered or cancelled
    $query = "SELECT order_id FROM orders WHERE order_id = ? AND user_id = ? AND status IN ('pending', 'going')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        throw new Exception("Order not found, does not belong to the user, or cannot be cancelled.");
    }

    $stmt->close();

    // Update order status to cancelled
    $query = "UPDATE orders SET status = 'cancelled' WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    // Get the ordered items
    $query = "SELECT product_id, quantity FROM order_items WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Return quantities to the items table
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];

        $update_query = "UPDATE items SET Quantity = Quantity + ? WHERE ItemId = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ii", $quantity, $product_id);
        $update_stmt->execute();
        $update_stmt->close();
    }

    $stmt->close();

    // Commit the transaction
    mysqli_commit($conn);

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    // Roll back the transaction in case of an error
    mysqli_rollback($conn);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

mysqli_close($conn);
?>
