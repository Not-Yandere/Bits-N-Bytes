document.addEventListener('DOMContentLoaded', function() {
    if (!isUserLoggedIn) {
        window.location.href = '/log-in';
    } else {
        loadOrders();
    }
});

function loadOrders() {
    fetch('/get-orders.php')
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                displayOrders(data);
            } else {
                document.querySelector('.orders-view').innerHTML = '<div class="empty"><b>No orders found.</b><br><a href="/">Shop now</a></div>';
            }
        })
        .catch(error => {
            console.error('Error fetching orders:', error);
            document.querySelector('.orders-view').innerHTML = '<h2>Error loading orders</h2>';
        });
}

function displayOrders(orders) {
    const ordersViewElement = document.querySelector('.orders-view');
    let ordersHTML = '';

    orders.forEach(order => {
        let itemsHTML = '';
        order.items.forEach(item => {
            itemsHTML += `
                <div class="order-item">
                    <img src="${item.Pic}" alt="${item.ProductName}" />
                    <div class="order-item-content">
                        <h3>${item.ProductName}</h3>
                        <p class="quantity">Quantity: ${item.quantity}</p>
                        <p class="price">EGP ${item.price}</p>
                    </div>
                </div>`;
        });

        let cancelBtnHTML = '';
        if (order.status !== 'delivered' && order.status !== 'cancelled') {
            cancelBtnHTML = `<button onclick="openCancelModal(${order.order_id})">Cancel Order</button>`;
        }

        ordersHTML += `
            <div class="order" id="order-${order.order_id}">
                <h2>Order ID: ${order.order_id}</h2>
                <p>Order Date: ${order.order_date}</p>
                <p>Total Price: EGP ${order.total_price}</p>
                <p>Status: ${order.status}</p>
                <div class="order-items">${itemsHTML}</div>
                <br>
                ${cancelBtnHTML}
            </div>`;
    });

    ordersViewElement.innerHTML = ordersHTML;
}


function openCancelModal(orderId) {
    const modal = document.getElementById('cancelOrderModal');
    modal.style.display = 'flex';
    document.getElementById('confirmCancelButton').onclick = function() {
        performCancelOrder(orderId);
    };
}

function performCancelOrder(orderId) {
    fetch('/cancel-order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ order_id: orderId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const orderElement = document.getElementById(`order-${orderId}`);
            orderElement.querySelector('button').remove();
            orderElement.querySelector('p:last-of-type').textContent = 'Status: cancelled';
            closeModal();
        } else {
            alert('Failed to cancel order: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error canceling order:', error);
        alert('An error occurred while canceling the order.');
    });
}

function closeModal() {
    const modal = document.getElementById('cancelOrderModal');
    modal.style.display = 'none';
}

// Ensure event listeners are attached only after the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('cancelButton').addEventListener('click', closeModal);
    document.getElementById('closeModalButton').addEventListener('click', closeModal);
});
