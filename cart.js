document.addEventListener('DOMContentLoaded', function() {
    if (!isUserLoggedIn) {
        window.location.href = '/log-in';
    } else {
        initializeCart();
    }
});
// Initialize cart with consistent data structure
function initializeCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => typeof item === 'object' && 'id' in item && 'quantity' in item);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

// Add item to cart
function addToCart(itemId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let item = cart.find(item => item.id === itemId);

    if (item) {
        item.quantity++;
    } else {
        cart.push({ id: itemId, quantity: 1 });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

// Remove item from cart
function removeFromCart(itemId) {
    var itemElement = document.getElementById(itemId);
    if (itemElement) {
        itemElement.style.animation = "fadeOut 0.5s ease-out forwards";
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart = cart.filter(item => item.id !== itemId);
            localStorage.setItem('cart', JSON.stringify(cart));
        setTimeout(function () {
            updateCartDisplay();
        }, 550);
    }
}

// Display cart items
function updateCartDisplay() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartViewElement = document.querySelector('.cart-view');
    const totalPriceElement = document.getElementById('total-price');
    const checkoutBox = document.querySelector('.chd');
    let total_price = 0;

    if (cart.length === 0) {
        cartViewElement.innerHTML = `
            <div class="empty">
                <img src="./Images/cart.png" alt="empty">
                <h1>Your Cart Is Empty</h1>
                <h4>add something to make us happy <sub><img src="Images/smile.png" alt="smile"></sub></h4>
                <a href="/">Shop now</a>
            </div>`;
        totalPriceElement.textContent = '0';
        checkoutBox.style.display = 'none';
        document.body.style.gridTemplateAreas = ''; // Remove grid template
        return;
    } else {
        checkoutBox.style.display = 'flex';
    }

    fetch('get-products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ cart: cart.map(item => item.id) })
    })
    .then(response => response.json())
    .then(data => {
        let cartHTML = '';
        data.forEach(item => {
            const price = parseFloat(item.Price.replace(/[^0-9.-]+/g, "")); // Remove any non-numeric characters
            const cartItem = cart.find(cartItem => cartItem.id === item.ItemId);
            total_price += price * cartItem.quantity;
            cartHTML += `<div class="cart-item" id="${item.ItemId}">
                <div class='image'>
                    <img src="${item.Pic}" alt="${item.ProductName}" />
                </div>
                <div>
                    <h2>${item.ProductName}</h2>
                    <h3 class="price"><span class="old-price"></span><span class="new-price"> Price: ${item.Price}</span></h3>
                    <div>
                        <button class="decrement-quantity" data-id="${item.ItemId}">-</button>
                        <span class="item-quantity" data-id="${item.ItemId}">${cartItem.quantity}</span>
                        <button class="increment-quantity" data-id="${item.ItemId}" ${cartItem.quantity >= item.Quantity ? 'disabled' : ''} ${cartItem.quantity >= item.Quantity ? 'style="cursor: not-allowed;"' : ''}>+</button>
                    </div>
                    <button class="delete" data-id="${item.ItemId}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg>
                    </button>
                </div>
            </div><br>`;
        });
        cartViewElement.innerHTML = cartHTML;
        totalPriceElement.textContent = total_price.toFixed(2);
        applyGridTemplate(cart); // Apply grid template after updating the cart display

        // Add event listeners to quantity controls
        document.querySelectorAll('.increment-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                incrementQuantity(itemId);
            });
        });

        document.querySelectorAll('.decrement-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                decrementQuantity(itemId);
            });
        });

        // Add event listeners to delete buttons
        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                removeFromCart(itemId);
            });
        });
    })
    .catch(error => {
        console.error('Error fetching cart items:', error);
        cartViewElement.innerHTML = '<h2>Error loading cart items</h2>';
    });
}

// Function to increment item quantity in the cart
function incrementQuantity(itemId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.map(item => {
        if (item.id == itemId) {
            item.quantity++;
        }
        return item;
    });
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

// Function to decrement item quantity in the cart
function decrementQuantity(itemId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.map(item => {
        if (item.id == itemId) {
            if (item.quantity > 1) {
                item.quantity--;
            } else {
                var itemElement = document.getElementById(itemId);
                if (itemElement) {
                    itemElement.style.animation = "fadeOut 0.5s ease-out forwards";
                    removeFromCart(itemId);
                }
            }
        }
        return item;
    });
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

// Function to set the body grid template based on cart contents and screen size
function applyGridTemplate(cart) {
    const screenSize = window.matchMedia("(max-width: 960px)");
    setGridTemplate(cart, screenSize); // Set the grid template based on cart contents and screen size
    screenSize.addEventListener("change", function() {
        setGridTemplate(cart, screenSize);
    });
}

// Function to define grid template areas
function setGridTemplate(cart, screenSize) {
    if (cart.length > 0) {
        if (screenSize.matches) {
            document.body.style.gridTemplateAreas =
            `"header header header header header header header header"
            "nav nav nav nav nav nav nav nav"
            "cont cont cont cont cont cont cont cont"
            "check check check check check check check check"
            "footer footer footer footer footer footer footer footer"`;
        } else {
            document.body.style.gridTemplateAreas =
            `"header header header header header header header header"
            "nav nav nav nav nav nav nav nav"
            "filter cont cont cont cont cont check check"
            "footer footer footer footer footer footer footer footer"`;
        }
    } else {
        document.body.style.gridTemplateAreas = '';
    }
}

// Checkout function

function checkout() {
    setTimeout(function () {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    $.ajax({
        url: 'checkout.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ cart: cart }),
        success: function(response) {
            // Handle successful checkout
            if (response.status === 'success') {
                localStorage.removeItem('cart');
                window.location.href = 'checkout_success.php'; 
            }
        },
        error: function(error) {
            // Handle checkout error
            console.error('Checkout failed:', error);
        }
    })},2500);
}

// Initialize cart with consistent data structure and display on page load
document.addEventListener('DOMContentLoaded', initializeCart);
