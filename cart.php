<?php
include 'config/db_connect.php';
$isUserLoggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=0.8" />
    <title>Bits N Bytes</title>
    <link rel="stylesheet" href="CSS/amazon.css" />
    <link rel="stylesheet" href="CSS/carttt.css" />
    <link rel="shortcut icon" href="Images/icon.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>var isUserLoggedIn = <?php echo json_encode($isUserLoggedIn); ?>;</script>
    <script src="/cart.js"></script> <!-- Include external JS file -->
</head>
<body>
<?php include 'header.php';?>
    <aside class="filter"></aside>
    <div class="cart-view"></div>
    <div class="chd" style="display: none;">
        <div>
            <h3>Total: EGP <span id="total-price">0</span></h3>
            <button class="checkout" onclick="checkout()">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24" id="cart">
                    <path fill="#f1faee" d="M17,18A2,2 0 0,1 19,20A2,2 0 0,1 17,22C15.89,22 15,21.1 15,20C15,18.89 15.89,18 17,18M1,2H4.27L5.21,4H20A1,1 0 0,1 21,5C21,5.17 20.95,5.34 20.88,5.5L17.3,11.97C16.96,12.58 16.3,13 15.55,13H8.1L7.2,14.63L7.17,14.75A0.25,0.25 0 0,0 7.42,15H19V17H7C5.89,17 5,16.1 5,15C5,14.65 5.09,14.32 5.24,14.04L6.6,11.59L3,4H1V2M7,18A2,2 0 0,1 9,20A2,2 0 0,1 7,22C5.89,22 5,21.1 5,20C5,18.89 5.89,18 7,18M16,11L18.78,6H6.14L8.5,11H16Z" />
                </svg>
                <span class="chh">Checkout</span>
                <svg id="check" style="width:35px;height:35px" viewBox="0 0 24 24">
                    <path stroke-width="2" fill="none" stroke="#ffffff" d="M 3,12 l 6,6 l 12, -12"/>
                </svg>
            </button>
        </div>
    </div>
    <aside class="ad"></aside>
</body>
</html>
