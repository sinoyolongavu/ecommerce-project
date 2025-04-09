<?php
//Database connection file
include_once 'db-inc.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReflectaHome Admin Notifications</title>
    <link rel="stylesheet" href="/ReflectaHome/Admin/style/styles.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .notifications-section {
            margin-top: 20px;
        }
        .card-notification {
            margin-bottom: 20px;
        }
        .notification-item {
            font-size: 18px;
        }
        .notification-time {
            font-size: 14px;
            color: #888;
        }
        .notification-actions {
            font-size: 18px;
        }
    </style>
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
                    <a class="nav-link active" href="notifications.php"><i class="fas fa-bell"></i> Notifications</a>
                </li>
                <!-- Manage Dropdown -->
               
               
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarManageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-gear"></i> Manage
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarManageDropdown">
                        <li><a class="dropdown-item" href="Users.php"><i class="fas fa-users"></i> Users</a></li>
                        <li><a class="dropdown-item" href="products.php"><i class="fas fa-tag"></i> Product</a></li>
                        <li><a class="dropdown-item" href="orders.php"><i class="fas fa-truck"></i> Orders</a></li>
                        <li><a class="dropdown-item" href="website.php"><i class="fas fa-globe"></i> Website</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/ReflectaHome/Homepage/home.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!-- Admin Notifications -->
<div class="container">
    <div class="row notifications-section">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Admin Notifications</h4>
                </div>
                <div class="card-body">
                    <!-- Notification List -->
                    <div class="list-group">
                        <div class="list-group-item notification-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Order #1056 placed by customer Owethu Sityata.</h5>
                                    <p class="notification-time">3 hours ago</p>
                                </div>
                                <div class="notification-actions">
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</a>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item notification-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Product 'Modern Rectangle Mirror' was updated.</h5>
                                    <p class="notification-time">1 day ago</p>
                                </div>
                                <div class="notification-actions">
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</a>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item notification-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">New customer registration: Armien Berg.</h5>
                                    <p class="notification-time">2 days ago</p>
                                </div>
                                <div class="notification-actions">
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</a>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item notification-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Order #1053 dispatched to address 26 453 Cape Town.</h5>
                                    <p class="notification-time">3 days ago</p>
                                </div>
                                <div class="notification-actions">
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</a>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item notification-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Product 'Classic Round Mirror' was added to the inventory.</h5>
                                    <p class="notification-time">4 days ago</p>
                                </div>
                                <div class="notification-actions">
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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


</body>
</html>
