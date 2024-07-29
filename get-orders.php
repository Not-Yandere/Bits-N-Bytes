<?php
include 'config/db_connect.php';

$user_id = $_SESSION['id'];

$query = "SELECT o.order_id, o.order_date, o.total_price, o.status, 
          GROUP_CONCAT(oi.product_id, ':', oi.quantity, ':', oi.price, ':', p.ProductName, ':', p.Pic) AS items
          FROM orders o
          JOIN order_items oi ON o.order_id = oi.order_id
          JOIN items p ON oi.product_id = p.ItemId
          WHERE o.user_id = ?
          GROUP BY o.order_id";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $items = explode(',', $row['items']);
    $orderItems = [];
    foreach ($items as $item) {
        list($product_id, $quantity, $price, $ProductName, $Pic) = explode(':', $item);
        $orderItems[] = [
            'product_id' => $product_id,
            'ProductName' => $ProductName,
            'quantity' => $quantity,
            'price' => $price,
            'Pic' => $Pic
        ];
    }
    $orders[] = [
        'order_id' => $row['order_id'],
        'order_date' => $row['order_date'],
        'total_price' => $row['total_price'],
        'status' => $row['status'],
        'items' => $orderItems
    ];
}

echo json_encode($orders);
$stmt->close();
$conn->close();
?>
