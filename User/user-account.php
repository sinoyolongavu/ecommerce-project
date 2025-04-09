<?php
// Include the database connection file
include_once 'db-inc.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Assuming the user is logged in and their ID is stored in the session
$userId = $_SESSION['user_id'];  // Get the user ID from the session

// Fetch user details from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $dbConnection->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated user details from the POST request
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null; // Check if password is provided and hash it
    $address = $_POST['address'];

    // Update the user details in the database
    if ($password) {
        // If password is provided, include it in the update query
        $sql = "UPDATE users SET fullname = ?, username = ?, email = ?, address = ?, password = ? WHERE id = ?";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bind_param("sssssi", $fullname, $username, $email, $address, $password, $userId);
    } else {
        // Otherwise, update without changing the password
        $sql = "UPDATE users SET fullname = ?, username = ?, email = ?, address = ? WHERE id = ?";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bind_param("ssssi", $fullname, $username, $email, $address, $userId);
    }

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Successfully updated
        header('Location: user-account.php?success=1');
        exit();
    } else {
        // Failed to update
        header('Location: user-account.php?error=1');
        exit();
    }

    $stmt->close();
}

// Close the database connection
$dbConnection->close();
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

    <br><br>
    <!-- User Account Section -->
    <section class="user-account">
        <div class="container">
            <h2>Update Your Account Information</h2>
            
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="alert alert-success">Your account information has been updated successfully!</div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <div class="alert alert-danger">Failed to update your account. Please try again.</div>
            <?php endif; ?>

            <form method="POST" action="user-account.php">
                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Leave empty to keep current password">
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required><?= htmlspecialchars($user['address']) ?></textarea>
                </div>

                <!-- Update Button -->
                <button type="submit" class="btn btn-primary">Update Account</button>
            </form>
        </div>
    </section>

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
                    <li><a href="/ReflectaHome/QuickLinks/about.html">About Us</a></li>
                    <li><a href="/ReflectaHome/QuickLinks/Report abuse.html">Report abuse</a></li>
                    <li><a href="/ReflectaHome/QuickLinks/Return Policy.html">Return Policy</a></li>
                    <li><a href="/ReflectaHome/QuickLinks/Shipping & Payment.html">Shipping & Payment Info</a></li>
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

    <!-- External JavaScript file -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
