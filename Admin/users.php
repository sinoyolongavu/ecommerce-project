<?php
// Database connection file
include_once 'db-inc.php';
session_start();

// Pagination settings
$usersPerPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $usersPerPage;

// Fetch total number of users
$sqlTotal = "SELECT COUNT(*) as total FROM users";
$resultTotal = mysqli_query($dbConnection, $sqlTotal);
$totalUsers = mysqli_fetch_assoc($resultTotal)['total'];

// Fetch users for the current page
$sql = "SELECT * FROM users LIMIT $offset, $usersPerPage";
$result = mysqli_query($dbConnection, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close the database connection
$dbConnection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReflectaHome Product</title>
    <link rel="stylesheet" href="/ReflectaHome/Admin/style/styles.css"> <!-- Link to the external CSS stylesheet -->

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (needed for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">
                <img src="/ReflectaHome/Images/logo-no-background.png" alt="ReflectaHome Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="Users.php"><i class="fas fa-users"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php"><i class="fas fa-tag"></i> Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php"><i class="fas fa-truck"></i> Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="website.php"><i class="fas fa-globe"></i> Website</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ReflectaHome/Homepage/home.php"><i class="fas fa-sign-out-alt"></i>
                            Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Manage Section Indicator -->
    <div class="container mt-3">
        <div class="alert alert-info text-center" role="alert">
            <strong>You are currently managing the Users!</strong>
        </div>
    </div>

    <!-- User Engagement Tracking Page Content -->
    <div class="container mt-4">
        <h2>User Engagement Tracking</h2>

        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" class="form-control" id="userSearch" placeholder="Search for users..." oninput="filterUsers()">
        </div>

        <!-- User Table -->
        <table class="table table-striped" id="userTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Last Activity</th>
                    <th>Total Orders</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="user-list">
                <?php
                // Display users with the auto-incremented ID
                $counter = ($page - 1) * $usersPerPage + 1; 
                foreach ($users as $user): ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= $user['fullname'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['last_activity'] ?></td>
                    <td><?= $user['total_orders'] ?></td>
                    <td><?= $user['status'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td>
                        <button class="btn btn-info" onclick="viewUserDetails(<?= $user['id'] ?>)">View</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center" id="pagination">
                <?php
                // Pagination logic
                $totalPages = ceil($totalUsers / $usersPerPage);
                for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="Users.php?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <!-- User Details Modal -->
    <div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailsModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Full Name:</strong> <span id="modalFullName"></span></p>
                    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                    <p><strong>Last Activity:</strong> <span id="modalLastActivity"></span></p>
                    <p><strong>Total Orders:</strong> <span id="modalTotalOrders"></span></p>
                    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                    <p><strong>Role:</strong>
                        <label class="switch">
                            <input type="checkbox" id="roleSwitch">
                            <span class="slider round"></span>
                        </label>
                    </p>
                    <p><strong>Ban Status:</strong>
                        <label class="switch">
                            <input type="checkbox" id="banSwitch">
                            <span class="slider round"></span>
                        </label>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="updateUser()">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <h3>ReflectaHome</h3>
                <p>Transform your space with our beautiful mirrors.</p>
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

    <script>
        // Global variable for storing users data (this could be fetched dynamically if needed)
        const users = <?= json_encode($users) ?>;

        // Function to filter users based on search input
        function filterUsers() {
            const searchQuery = document.getElementById("userSearch").value.toLowerCase();
            const userRows = document.querySelectorAll("#userTable tbody tr");

            userRows.forEach(row => {
                const fullName = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();

                if (fullName.includes(searchQuery) || email.includes(searchQuery)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        // Function to view user details
        function viewUserDetails(userId) {
            const user = users.find(u => u.id === userId);

            // Populate the modal with user data
            document.getElementById('modalFullName').textContent = user.fullname;
            document.getElementById('modalEmail').textContent = user.email;
            document.getElementById('modalLastActivity').textContent = user.last_activity;
            document.getElementById('modalTotalOrders').textContent = user.total_orders;
            document.getElementById('modalStatus').textContent = user.status;

            // Set the role and ban switches
            document.getElementById('roleSwitch').checked = user.role === 'admin';
            document.getElementById('banSwitch').checked = user.status === 'inactive';

            // Show the modal
            const userDetailsModal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
            userDetailsModal.show();
        }

        // Function to update user details
        function updateUser() {
            const userId = document.getElementById('modalUserId').textContent;
            const role = document.getElementById('roleSwitch').checked ? 'admin' : 'user';
            const banned = document.getElementById('banSwitch').checked ? 'inactive' : 'active';

            fetch('update-user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: userId,
                    role: role,
                    status: banned
                })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    alert('User updated successfully!');
                    location.reload(); // Reload to see the changes
                } else {
                    alert('Error updating user');
                }
            });
        }
    </script>

</body>

</html>
