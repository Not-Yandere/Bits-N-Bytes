<?php
include '../config/db_connect.php';

$ItemId = $_GET['ItemId'];
$result = mysqli_query($conn, "SELECT * from items WHERE ItemId ='$ItemId' ");
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn);
} else {
    $row = array(
        'ItemId' => null,
        'ProductName' => "item doesn't exist",
        'Description' => "item doesn't exist",
        'Price' => "item doesn't exist",
        'Pic' => "item doesn't exist",
        'Quantity' => 0 // Ensure Quantity is set
    );
}

$isLoggedIn = isset($_SESSION['user']); // Check if user is logged in
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=0.8" />
    <title><?php echo htmlspecialchars($row['ProductName']); ?></title>
    <link rel="stylesheet" href="/CSS/amazon.css" />
    <link rel="stylesheet" href="/CSS/product.css" />
    <link rel="stylesheet" href="/CSS/carttt.css" />
    <link rel="shortcut icon" href="/Images/icon.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="/cart.js"></script> <!-- Ensure the correct path to cart.js -->
</head>
<body>
    <?php include 'header1.php';?>
    <?php if (is_null($row['ItemId'])) {?>
        <div class="empty"><br><br>
        <h1>This Item Doesn't Exist</h1>
        <br><br></div>
    <?php } else {?>
        <div class="product-page">
            <div class="container"><img src="<?php echo htmlspecialchars($row['Pic']); ?>" alt="<?php echo htmlspecialchars($row['ProductName']); ?>" loading="lazy"/></div>
            <div class="product-data">
                <h1 class="product-name"><?php echo htmlspecialchars($row['ProductName']); ?></h1>
                <p class="product-desc"><?php echo htmlspecialchars($row['Description']); ?></p>
                <h2 class="price"><span class="old-price"></span><span class="new-price"><?php echo htmlspecialchars($row['Price']); ?></span></h2>
                <button class="cart-button" id="cart-button">
                    <span class="add-to-cart">add to cart</span>
                    <span class="added">added to cart</span>
                    <span class="fas fa-shopping-cart"><img src="/Images/cart1.svg"></span>
                    <span class="fas fa-box"><img src="/Images/cart2.svg"></span>
                </button>
                <p id="stock-info"></p> 
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const addToCartButton = document.querySelector('#cart-button');
                        const stockInfo = document.querySelector('#stock-info');
                        const availableQuantity = parseInt("<?php echo $row['Quantity']; ?>", 10);
                        const productId = "<?php echo $row['ItemId']; ?>";
                        const isLoggedIn = "<?php echo $isLoggedIn ? 'true' : 'false'; ?>";

                        // Function to check if the item is in the cart
                        function isInCart(productId) {
                            const cart = JSON.parse(localStorage.getItem('cart')) || [];
                            return cart.some(item => item.id === productId.toString());
                        }

                        // Check if the item is in the cart and update the button
                        if (isInCart(productId)) {
                            addToCartButton.disabled = true;
                            addToCartButton.style.cursor = "not-allowed";
                            addToCartButton.querySelector('.add-to-cart').textContent = 'added to cart';
                        }

                        // Update stock information
                        if (availableQuantity > 0) {
                            if (availableQuantity <= 10) {
                                stockInfo.innerHTML = `<strong>Only </strong>${availableQuantity}<strong> Available In Stock !!</strong>`;

                                stockInfo.style.color = 'red';
                            }
                        } else {
                            addToCartButton.disabled = true;
                            addToCartButton.style.cursor = "not-allowed";
                            addToCartButton.querySelector('.add-to-cart').innerHTML = '<strong>Out of Stock</strong>';
                        }

                        // Add event listener to the cart button
                        addToCartButton.addEventListener('click', function() {
                            if (isLoggedIn === 'true') {
                                addToCart(productId);
                                let button = this;
                                button.classList.add('clicked');
                                button.disabled = true;
                                button.style.cursor = "not-allowed";
                            } else {
                                window.location.href = '/log-in'; // Redirect to login page if not logged in
                            }
                        });

                        // Function to add item to cart
                        function addToCart(productId) {
                            let cart = JSON.parse(localStorage.getItem('cart')) || [];
                            let item = cart.find(item => item.id === productId);

                            if (item) {
                                item.quantity++;
                            } else {
                                cart.push({ id: productId, quantity: 1 });
                            }

                            localStorage.setItem('cart', JSON.stringify(cart));
                        }
                    });
                </script>
            </div>
        </div>
    <?php }?>
</body>
</html>
