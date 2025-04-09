<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ReflectaHome/Styles/style.css"> 
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
                <img src="/ReflectaHome/Images/logo-no-background.png" alt="ReflectaHome Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php#products"><i class="fas fa-store"></i> Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php"><i class="fas fa-truck"></i> Orders</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" href="signup-in.php"><i class="fas fa-user"></i> Sign Up / Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart <span id="cart-count"></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="checkout-container">
        <h1>Secure Checkout</h1>

        <!-- Cart Items Display -->
        <section class="checkout-items">
            <!-- Checkout items will be injected here by JavaScript -->
        </section>

        <!-- Customer Information -->
        <section class="customer-info">
            <h2>Customer Information</h2>
            <form id="checkout-form">
                <label for="name">Full Name & Surname</label>
                <input type="text" id="name" required>
                <div class="error-message" id="name-error">Please fill in your full name.</div>

                <label for="email">Email Address</label>
                <input type="email" id="email" required>
                <div class="error-message" id="email-error">Please fill in your email address and ensure it contains '@'.</div>

                <label for="address">Shipping Address</label>
                <input type="text" id="address" required>
                <div class="error-message" id="address-error">Please fill in your shipping address.</div>

                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" required>
                <div class="error-message" id="phone-error">Please fill in your phone number. It must be 10 digits and start with '0'.</div>
            </form>
        </section>

        <!-- Payment Method -->
        <section class="payment-method">
            <h2>Select Payment Method</h2>
            <div class="payment-options">
                <input type="radio" name="payment-method" value="credit-card" id="credit-card" checked>
                <label for="credit-card">Credit or Debit Card</label>
                <input type="radio" name="payment-method" value="paypal" id="paypal">
                <label for="paypal">PayPal</label>
            </div>
        </section>

        <!-- Credit Card Info -->
        <section class="credit-card-info" id="credit-card-info">
            <h3>Credit or Debit Card Details</h3>
            <label for="card-number">Card Number</label>
            <input type="text" id="card-number" placeholder="1234567891011121" required>
            <div class="error-message" id="card-number-error">Please fill in a valid card number.</div>

            <label for="expiry-date">Expiration Date</label>
            <input type="text" id="expiry-date" placeholder="MM/YY" required>
            <div class="error-message" id="expiry-date-error">Please fill in the expiration date.</div>

            <label for="cvv">CVV</label>
            <input type="text" id="cvv" placeholder="123" required>
            <div class="error-message" id="cvv-error">Please fill in the CVV.</div>
        </section>

        <!-- PayPal Info -->
        <section class="paypal-info" id="paypal-info" style="display: none;">
            <h3>Pay with PayPal</h3>
            <div id="paypal-button-container"></div>
        </section>

        <!-- Order Summary -->
        <section class="order-summary">
            <h2>Order Summary</h2>
            <p>Total: R100.00</p>
            <button type="button" id="submit-btn" class="submit-btn">Complete Order</button>
            <p id="success-message" class="success-message" style="display: none;">Payment successful!</p>
        </section>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <h3>ReflectaHome</h3>
                <p>Transform your space with our beautiful mirrors.</p><br><br>
                
            </div>
            <div class="footer-center">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="/ReflectaHome/QuickLinks/about.php">About Us</a></li>
                    <li><a href="/ReflectaHome/QuickLinks/Report abuse.php">Report abuse</a></li>
                    <li><a href="/ReflectaHome/QuickLinks/Return Policy.php">Return Policy</a></li>
                    <li><a href="/ReflectaHome/QuickLinks/Shipping & Payment.php">Shipping & Payment Info</a></li>
                </ul>
            </div>
            <div class="footer-right">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#" class="social-icon"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i> Instagram</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 ReflectaHome. All rights reserved.</p>
        </div>
    </footer>

    <!-- External JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="app.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            if (cart.length === 0) {
                window.location.href = 'cart.php'; // Redirect if no items in cart
                return;
            }

            const checkoutItemsContainer = document.querySelector('.checkout-items');
            let total = 0;

            cart.forEach(item => {
                total += item.price * item.quantity;
                checkoutItemsContainer.innerHTML += `
                    <div class="checkout-item d-flex align-items-center mb-3">
                        <img src="${item.image}" alt="${item.name}" class="cart-image" style="width: 80px;">
                        <div class="checkout-item-details ms-3">
                            <h5>${item.name}</h5>
                            <p class="price">R${item.price.toFixed(2)}</p>
                            <p>Quantity: ${item.quantity}</p>
                        </div>
                    </div>
                `;
            });

            document.querySelector('.order-summary p').textContent = `Total: R${total.toFixed(2)}`;

            // Handle form submission for checkout
            document.getElementById('submit-btn').addEventListener('click', function(event) {
                event.preventDefault();

                // Validate form fields
                let isValid = true;
                const fields = ['name', 'email', 'address', 'phone'];
                fields.forEach(field => {
                    const fieldValue = document.getElementById(field).value.trim();
                    if (!fieldValue) {
                        document.getElementById(`${field}-error`).style.display = 'block';
                        isValid = false;
                    } else {
                        document.getElementById(`${field}-error`).style.display = 'none';
                    }
                });

                if (!isValid) {
                    return;
                }

                // Simulate payment success (You can replace this with actual payment handling code)
                let isPaymentSuccessful = true;
                if (isPaymentSuccessful) {
                    localStorage.removeItem('cart');
                    document.getElementById('success-message').style.display = 'block';
                    document.getElementById('submit-btn').textContent = 'Order Completed';
                } else {
                    alert('Payment failed. Please try again.');
                }
            });
        });

        // PayPal Button Integration
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '100.00'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    document.getElementById('success-message').style.display = 'block';
                    document.getElementById('submit-btn').textContent = 'Order Completed';
                });
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
