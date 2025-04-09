<?php
//Database connection file
include_once 'db-inc.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - ReflectaHome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link" href="home.php#products"><i class="fas fa-store"></i> Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php"><i class="fas fa-truck"></i> Orders</a>
                    </li>
                   <!-- Combined Sign Up/Sign In Link -->
                    <li class="nav-item">
                         <a class="nav-link" href="signup-in.php"><i class="fas fa-user"></i> Sign Up / Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Page Content -->
    <div class="container mt-5">
        <h2>Your Cart</h2>

        <!-- Cart Items will be displayed here dynamically -->
        <div class="cart-items"></div>

        <div class="cart-footer mt-4 d-flex justify-content-between">
            <p><strong>Total:</strong> R6,000.00</p>
            <button class="btn btn-primary" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Function to update the total in the cart (for the static sample items)
        function updateCartTotal() {
            let total = 0;
            const cartItems = document.querySelectorAll('.cart-item');
            cartItems.forEach(item => {
                const priceElement = item.querySelector('.price');
                const quantityElement = item.querySelector('input[type="number"]');
                const price = parseFloat(priceElement.textContent.replace('R', '').replace(',', '').trim());
                const quantity = parseInt(quantityElement.value);
                total += price * quantity;
            });
            const totalElement = document.querySelector('.cart-footer p');
            totalElement.innerHTML = `<strong>Total:</strong> R${total.toFixed(2)}`;
        }

        const quantityInputs = document.querySelectorAll('input[type="number"]');
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                updateCartTotal();
            });
        });

        const removeButtons = document.querySelectorAll('.btn-danger');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const cartItem = this.closest('.cart-item');
                cartItem.remove();
                updateCartTotal();
            });
        });

        updateCartTotal();
    </script>

    <!-- Dynamically load products from localStorage -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Read cart data from localStorage
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        // If products have been added, override the sample content
        if (cart.length > 0) {
            const cartItemsContainer = document.querySelector('.cart-items');
            cartItemsContainer.innerHTML = ""; // clear sample items
            let total = 0;
            cart.forEach((item, index) => {
                total += item.price * item.quantity;
                cartItemsContainer.innerHTML += `
                    <div class="cart-item d-flex align-items-center mb-3">
                        <img src="${item.image}" alt="${item.name}" class="cart-image" style="width: 80px;">
                        <div class="cart-item-details ms-3">
                            <h5>${item.name}</h5>
                            <p class="price">R${item.price.toFixed(2)}</p>
                            <input type="number" value="${item.quantity}" class="form-control quantity-input" style="width: 80px;" data-index="${index}">
                            <button class="btn btn-danger mt-2 remove-item" data-index="${index}">Remove</button>
                        </div>
                    </div>
                `;
            });
            document.querySelector('.cart-footer p').innerHTML = `<strong>Total:</strong> R${total.toFixed(2)}`;
            
            // Attach event listeners for remove buttons
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const idx = this.getAttribute("data-index");
                    let cart = JSON.parse(localStorage.getItem("cart"));
                    cart.splice(idx, 1);
                    localStorage.setItem("cart", JSON.stringify(cart));
                    location.reload();
                });
            });
            
            // Attach event listeners for quantity inputs
            document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', function() {
        const idx = this.getAttribute("data-index");
        let newQty = parseInt(this.value);
        if (isNaN(newQty) || newQty <= 0) {
            return; // Prevents accidental deletion if input is invalid
        }
        let cart = JSON.parse(localStorage.getItem("cart"));
        cart[idx].quantity = newQty;
        localStorage.setItem("cart", JSON.stringify(cart));
        location.reload();
    });
});

        }
    });
    </script>

     <!-- Footer Section -->
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

  <style>
/* Ensure that the body and html elements take full height */
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

/* This will make the main content area grow and push footer down */
body {
    display: flex;
    flex-direction: column;
}

/* The content section (main) should take the remaining space */
.container {
    flex: 1;
}

/* Footer styling */
.footer {
    background-color: #333;
    color: white;
    padding: 20px 0;
    text-align: center;
    position: relative;
    bottom: 0;
    width: 100%;
}

/* This will ensure the footer stays at the bottom */
.footer .footer-content {
    display: flex;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Footer sections (left, center, right) */
.footer .footer-left, .footer .footer-center, .footer .footer-right {
    width: 30%;
}

/* Footer left section styling */
.footer .footer-left h3 {
    font-size: 24px;
    color: white;
}

/* Footer center and right section heading styling */
.footer .footer-center h4, .footer .footer-right h4 {
    font-size: 20px;
    color: white;
}

/* Footer links styling */
.footer .footer-center ul {
    list-style-type: none;
    padding: 0;
}

.footer .footer-center ul li {
    font-size: 16px;
    margin-bottom: 10px;
}

.footer .footer-center ul li a {
    text-decoration: none;
    color: #bbb;
    font-weight: 500;
}

.footer .footer-center ul li a:hover {
    color: white;
}

/* Footer bottom text styling */
.footer .footer-bottom {
    font-size: 14px;
    margin-top: 20px;
    color: #bbb;
}

/* Social media icons styling */
.social-links {
    display: flex;
    justify-content: center; /* Center the social icons */
    margin-top: 10px;
}

.social-links a {
    margin: 0 10px; /* Adds space between the icons */
    color: white;
    font-size: 18px;
    text-decoration: none;
}

.social-links a:hover {
    color: #ccc;
}

/* Responsive Design - Center the content in smaller screens */
@media (max-width: 768px) {
    /* Make the footer content stack vertically on smaller screens */
    .footer .footer-content {
        flex-direction: column;
        align-items: center; /* Center content in the middle */
        text-align: center;
    }

    .footer .footer-left, .footer .footer-center, .footer .footer-right {
        width: 100%;
        margin-bottom: 20px; /* Add some space between sections */
    }

    /* Ensure the social links are also centered */
    .social-links {
        justify-content: center; /* Keep the social icons centered */
    }
}
</style>


  
</body>
</html>
