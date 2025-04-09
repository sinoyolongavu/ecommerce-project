<?php
// Include the database connection file
include_once 'db-inc.php';
// Check if the user is logged in, redirect if not
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signup-in.php');
    exit();
}
// Get the user_id from session
$userId = $_SESSION['user_id'];
// Handle incoming POST requests for syncing orders
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $ordersData = json_decode(file_get_contents("php://input"), true);
    if ($ordersData && is_array($ordersData)) {
        foreach ($ordersData as $order) {
            // Prepare SQL to insert the order data
            $orderId = $order['orderId'];
            $status = $order['status'];
            $courier = $order['courier'];
            $trackingNumber = $order['trackingNumber'];
            // Insert order into orders table, including user_id
            $stmt = $dbConnection->prepare("INSERT INTO orders (order_id, status, courier, tracking_number, user_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $orderId, $status, $courier, $trackingNumber, $userId);
            $stmt->execute();
            // Insert products related to the order (assuming each order has an array of products)
            foreach ($order['products'] as $product) {
                $productName = $product['name'];
                $productPrice = $product['price'];
                $productQuantity = $product['quantity'];
                // Insert product into the products table (or related table)
                $stmtProduct = $dbConnection->prepare("INSERT INTO order_products (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
                $stmtProduct->bind_param("ssdi", $orderId, $productName, $productPrice, $productQuantity);
                $stmtProduct->execute();
            }
        }
        // Respond with success
        echo json_encode(["success" => true]);
    } else {
        // Respond with failure
        echo json_encode(["success" => false, "error" => "Invalid data"]);
    }
    $dbConnection->close();
    exit();
}
?>
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
<!-- Manage Section Indicator -->
<div class="container mt-3">
    <div class="alert alert-info text-center" role="alert">
        <strong>Thank you for shopping with ReflectaHome, now track your order</strong>
    </div>
</div>
    <br><br>
    <!-- Orders History Content -->
    <div class="container mt-5">
        <h2>Your Order Status</h2>
        <div class="orders-history"></div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
                    <a href="#" class="social-icon">Facebook</a>
                    <a href="#" class="social-icon">Instagram</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 ReflectaHome. All rights reserved.</p>
        </div>
    </footer>
    <script>
        // Function to load the order history
        document.addEventListener("DOMContentLoaded", function() {
            let orders = JSON.parse(localStorage.getItem("orders")) || [];
            if (orders.length === 0) {
                document.querySelector('.orders-history').innerHTML = "<p>You have no order history.</p>";
                return;
            }
            let ordersContainer = document.querySelector('.orders-history');
            ordersContainer.innerHTML = ""; // Clear any previous content
            orders.forEach((order, index) => {
                let orderHTML = `
                    <div class="order-item mb-4">
                        <h4>Order #${order.orderId} - ${order.status}</h4>
                        <ul class="list-group">`;
                order.products.forEach(product => {
                    orderHTML += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <img src="${product.image}" alt="${product.name}" style="width: 80px; height: 80px; object-fit: cover;" class="me-3">
                                <div>
                                    <h5>${product.name}</h5>
                                    <p>Price: R${product.price.toFixed(2)}</p>
                                    <p>Quantity: ${product.quantity}</p>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-info" onclick="trackOrder('${order.courier}', '${order.trackingNumber}')">Track Order</button>
                            </div>
                        </li>
                    `;
                });
                // Add Remove Button
                orderHTML += `
                    <div class="mt-3">
                        <button class="btn btn-danger" onclick="removeOrder(${index})">Remove Order</button>
                    </div>
                `;
                orderHTML += `</ul></div>`;
                ordersContainer.innerHTML += orderHTML;
            });
            // Call backend function to sync the orders with the database
            syncOrdersWithDatabase(orders);
        });
        // Function to remove an order
        function removeOrder(index) {
            let orders = JSON.parse(localStorage.getItem("orders")) || [];
            orders.splice(index, 1);  // Remove the order at the given index
            localStorage.setItem("orders", JSON.stringify(orders));  // Update localStorage
            location.reload();  // Reload the page to reflect the changes
        }
        // Function to track the order
        // function trackOrder(courier, trackingNumber) {
        //     if (courier === "picknpay") {
        //         window.open(`https://www.pnp.co.za/tracking?trackingNumber=${trackingNumber}`, "_blank");
        //     } else if (courier === "peppaxi") {
        //         window.open(`https://www.pepstores.com/track-your-parcel?trackingNumber=${trackingNumber}`, "_blank");
        //     } else if (courier === "dhl") {
        //         window.open(`https://www.dhl.com/en/express/tracking.html?AWB=${trackingNumber}`, "_blank");
        //     } else if (courier === "aramex") {
        //         window.open(`https://www.aramex.com/track/track-result?trackingnumber=${trackingNumber}`, "_blank");
        //     } else if (courier === "postnet") {
        //         window.open(`https://www.postnet.co.za/track-your-parcel/?trackingnumber=${trackingNumber}`, "_blank");
        //     } else {
        //         window.open(`https://www.dhl.com/en/express/tracking.html?AWB=${trackingNumber}`, "_blank");
        //     }
        // }
        // Function to sync orders with the database
        function syncOrdersWithDatabase(orders) {
            if (orders.length === 0) return;
            // Send the order data to the PHP backend
            fetch('orders.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(orders),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Orders synced successfully.");
                } else {
                    console.log("Failed to sync orders.");
                }
            })
            .catch(error => {
                console.error("Error syncing orders:", error);
            });
        }
    </script>
</body>
</html>






