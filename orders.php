<?php
include 'config/db_connect.php';
$isUserLoggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=0.8" />
    <title>Bits N Bytes - Orders</title>
    <link rel="stylesheet" href="/CSS/amazon.css" />
    <link rel="stylesheet" href="/CSS/orders.css" /> <!-- Include the new CSS file -->
    <link rel="stylesheet" href="/CSS/carttt.css" />
    <link rel="shortcut icon" href="/Images/icon.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>var isUserLoggedIn = <?php echo json_encode($isUserLoggedIn); ?>;</script>
    <script src="/orders.js"></script> <!-- Include external JS file -->
</head>
<body>
<?php include 'header.php';?>
<div class="orders-view"></div>

<!-- Cancel Order Modal -->
<div id="cancelOrderModal" class="modal">
    <div class="modal-content">
        <span class="close-button" id="closeModalButton">&times;</span>
        <h2>Cancel Order</h2>
        <p>Are you sure you want to cancel this order?</p>
        <button id="confirmCancelButton">Yes, Cancel</button>
        <button id="cancelButton">No, Keep Order</button>
    </div>
</div>

<aside class="ad"></aside>
</body>
</html>
