<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReflectaHome - Update Account</title>
    <link rel="stylesheet" href="/ReflectaHome/Styles/style.css"> 

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.html">
                <img src="/ReflectaHome/Images/logo-no-background.png" alt="ReflectaHome Logo" style="height: 40px;">
            </a>
        
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="user-dashboard.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="user-account.php"><i class="fas fa-user"></i> My Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php"><i class="fas fa-truck"></i> Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart <span id="cart-count"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ReflectaHome/Homepage/home.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
    
  </style>

</body>
</html>
