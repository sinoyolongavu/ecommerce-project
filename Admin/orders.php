<?php
// Include the database connection file
include_once 'db-inc.php';
// Initialize pagination variables
$limit = 10;  // Number of orders per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
// Initialize search term (search by created_at)
$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
// Query to fetch orders with pagination and search by created_at
$sql = "
    SELECT o.order_id, o.status, o.created_at, u.email
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.created_at LIKE ?
    LIMIT ? OFFSET ?
";
$stmt = $dbConnection->prepare($sql);
$stmt->bind_param("sii", $searchTerm, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
// Count total orders for pagination
$countSql = "SELECT COUNT(*) AS total FROM orders o JOIN users u ON o.user_id = u.id WHERE o.created_at LIKE ?";
$countStmt = $dbConnection->prepare($countSql);
$countStmt->bind_param("s", $searchTerm);
$countStmt->execute();
$countResult = $countStmt->get_result();
$countRow = $countResult->fetch_assoc();
$totalOrders = $countRow['total'];
$totalPages = ceil($totalOrders / $limit);
$dbConnection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReflectaHome - Manage Orders</title>
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
            <a class="navbar-brand" href="index.html">
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
                        <a class="nav-link" href="Users.php"><i class="fas fa-users"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="products.php"><i class="fas fa-tag"></i> Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php"><i class="fas fa-truck"></i> Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="website.php"><i class="fas fa-globe"></i> Website</a>
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
            <strong>You are currently managing orders!</strong>
        </div>
    </div>
    <br><br>
    <!-- Orders Table and Search Bar -->
    <div class="container mt-5">
        <h2>Manage Orders</h2>
        <!-- Search Bar -->
        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search orders by date (YYYY-MM-DD)" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
            </div>
        </form>
        <!-- Orders Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">User Email</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_id']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td><?= htmlspecialchars($order['created_at']) ?></td>
                        <td><?= htmlspecialchars($order['email']) ?></td>
                        <td>
                            <!-- Change Status Button -->
                            <!-- <form method="POST" action="change_status.php" class="d-inline-block"> -->
                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                <select name="status" class="form-control form-control-sm">
                                    <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                </select>
                                <button type="submit" class="btn btn-warning btn-sm mt-2">Change Status</button>
                            </form>
                            <!-- Track Order Button (Redirect to Courier's Website) -->
                            <button class="btn btn-info btn-sm mt-2" onclick="trackOrder(<?= $order['order_id'] ?>)">Track</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=1&search=<?= htmlspecialchars($_GET['search'] ?? '') ?>">First</a></li>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= htmlspecialchars($_GET['search'] ?? '') ?>">Previous</a></li>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($_GET['search'] ?? '') ?>">Next</a></li>
                    <li class="page-item"><a class="page-link" href="?page=<?= $totalPages ?>&search=<?= htmlspecialchars($_GET['search'] ?? '') ?>">Last</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function trackOrder(orderId) {
            // Call APIs to get tracking data
            const aramexUrl = `https://api.aramex.com/track/${orderId}`;
            const dhlUrl = `https://api.dhl.com/track/${orderId}`;
            // Make a fetch request to Aramex and DHL (for demonstration)
            fetch(aramexUrl)
                .then(response => response.json())
                .then(data => {
                    alert('Aramex Tracking Info: ' + JSON.stringify(data));
                })
                .catch(error => alert('Error fetching Aramex tracking info.'));
            fetch(dhlUrl)
                .then(response => response.json())
                .then(data => {
                    alert('DHL Tracking Info: ' + JSON.stringify(data));
                })
                .catch(error => alert('Error fetching DHL tracking info.'));
        }
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
</body>
</html>