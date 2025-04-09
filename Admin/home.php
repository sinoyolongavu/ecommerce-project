<?php
//Database connection file
include_once 'db-inc.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReflectaHome Admin Dashboard</title>
    <link rel="stylesheet" href="/ReflectaHome/Admin/style/styles.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js for graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .dashboard-section {
            margin-top: 20px;
        }
        .card-dashboard {
            margin-bottom: 20px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .card-dashboard:hover {
            transform: scale(1.1);
        }
        .card-body {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .quicklink-card {
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: dance 1s infinite alternate;
        }

        @keyframes dance {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0);
            }
        }

        .welcome-message {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
        }

        .graph-container {
            margin-top: 30px;
        }

        .mirror-deco {
            text-align: center;
            margin-top: 50px;
            padding: 30px;
            background-color: #f9f9f9;
        }

        .mirror-deco img {
            max-width: 100%;
            height: auto;
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



<!-- Admin Dashboard -->
<div class="container">
    <div class="row dashboard-section">
        <!-- Welcome Message -->
        <div class="col-md-12">
            <div class="welcome-message">
                <p>Welcome back, Admin! Here is your dashboard overview.</p>
            </div>
        </div>
    </div>

    <div class="row dashboard-section text-center">
        <!-- Quick Link Cards -->
        <div class="col-md-2 col-sm-4">
            <div class="card card-dashboard quicklink-card bg-primary text-white" onclick="window.location.href='products.php'">
                <div class="card-body">
                    <i class="fas fa-tag fa-3x"></i>
                    <p>Products</p>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="card card-dashboard quicklink-card bg-warning text-white" onclick="window.location.href='notifications.php'">
                <div class="card-body">
                    <i class="fas fa-bell fa-3x"></i>
                    <p>Notifications</p>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="card card-dashboard quicklink-card bg-success text-white" onclick="window.location.href='orders.php'">
                <div class="card-body">
                    <i class="fas fa-truck fa-3x"></i>
                    <p>Orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="card card-dashboard quicklink-card bg-info text-white" onclick="window.location.href='Users.php'">
                <div class="card-body">
                    <i class="fas fa-users fa-3x"></i>
                    <p>Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="card card-dashboard quicklink-card bg-dark text-white" onclick="window.location.href='website.php'">
                <div class="card-body">
                    <i class="fas fa-globe fa-3x"></i>
                    <p>Website</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphs Section -->
    <div class="graph-container">
        <!-- Sales Overview (Pie Chart) -->
        <div class="row">
            <div class="col-md-6">
                <canvas id="salesOverviewPieChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="salesLineChart"></canvas>
            </div>
        </div>

        <!-- Bar Graph (Sales by Mirror Type) -->
        <div class="row">
            <div class="col-md-12">
                <canvas id="salesBarChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Mirror Deco Section -->
    <div class="mirror-deco">
        <h3>Transform Your Space</h3>
        <p>Explore our stunning mirror collections.</p>
        <img src="/ReflectaHome/Admin/images/collection.jpg" alt="Mirror Decoration" />
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

<!-- JavaScript for Graphs -->
<script>
    // Sales Overview Pie Chart (Reflecting the three mirror types)
    const salesOverviewPieChart = new Chart(document.getElementById("salesOverviewPieChart"), {
        type: 'pie',
        data: {
            labels: ['Round Mirrors', 'Square Mirrors', 'Customized Mirrors'],
            datasets: [{
                label: 'Sales Overview',
                data: [35, 45, 20], // Sales distribution for mirrors
                backgroundColor: ['#ff9f00', '#36a2eb', '#4bc0c0'],
            }]
        }
    });

    // Sales Line Chart (Reflecting sales growth for mirrors)
    const salesLineChart = new Chart(document.getElementById("salesLineChart"), {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Mirror Sales Growth',
                data: [120, 150, 130, 180, 210, 250], // Sales growth data for mirrors
                borderColor: '#4bc0c0',
                fill: false
            }]
        }
    });

    // Sales by Mirror Type Bar Chart
    const salesBarChart = new Chart(document.getElementById("salesBarChart"), {
        type: 'bar',
        data: {
            labels: ['Round Mirrors', 'Square Mirrors', 'Customized Mirrors'],
            datasets: [{
                label: 'Sales by Mirror Type',
                data: [1200, 1500, 800], // Sales numbers for each mirror type
                backgroundColor: ['#ff9f00', '#36a2eb', '#4bc0c0'],
            }]
        }
    });
</script>

</body>
</html>
