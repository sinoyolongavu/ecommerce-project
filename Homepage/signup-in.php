<?php
// Include the database connection file
include_once 'db-inc.php';
session_start();

// Handle login request (signing in)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Prepare the SQL query to fetch the user
        $stmt = $dbConnection->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $db_email, $db_password, $role);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $db_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['email'] = $db_email;
                $_SESSION['role'] = $role;

                // Redirect based on role
                if ($role == 'admin') {
                    header("Location: /ReflectaHome/Admin/home.php");
                } else {
                    header("Location: /ReflectaHome/User/user-dashboard.php");
                }
                exit();
            } else {
                $error = 'Invalid password!';
            }
        } else {
            $error = 'No account found with this email!';
        }

        $stmt->close();
    } else {
        $error = 'Please enter both email and password.';
    }

    $dbConnection->close();
}

// Handle registration request (creating a new user account)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Get form data
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $agree = isset($_POST['agree']) ? true : false;

    // Check if all required fields are filled
    if (!empty($fullname) && !empty($username) && !empty($email) && !empty($password) && !empty($address) && $agree) {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format!";
        } else {
            // Check if the email already exists in the database
            $stmt = $dbConnection->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows > 0) {
                $error = "An account with this email already exists!";
            } else {
                // Hash the password before storing
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert the new user into the database
                $stmt = $dbConnection->prepare("INSERT INTO users (fullname, username, email, password, address, role) VALUES (?, ?, ?, ?, ?, 'user')");
                $stmt->bind_param("sssss", $fullname, $username, $email, $hashed_password, $address);

                if ($stmt->execute()) {
                    // Set session variables
                    $_SESSION['user_id'] = $dbConnection->insert_id;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = 'user';

                    // Redirect to the user dashboard
                    header("Location: /ReflectaHome/User/user-dashboard.php");
                    exit();
                } else {
                    $error = "An error occurred during registration. Please try again later.";
                }
            }
            $stmt->close();
        }
    } else {
        $error = "Please fill in all fields and agree to the terms.";
    }
}

// Handle the lost password form request (resetting the password)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resetPassword'])) {
    $email = $_POST['email'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if email exists in the database
    if (!empty($email) && !empty($newPassword) && !empty($confirmPassword)) {
        if ($newPassword === $confirmPassword) {
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format!";
            } else {
                // Check if email exists
                $stmt = $dbConnection->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    // Hash the new password before updating
                    $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Update the password in the database
                    $stmt = $dbConnection->prepare("UPDATE users SET password = ? WHERE email = ?");
                    $stmt->bind_param("ss", $hashed_password, $email);

                    if ($stmt->execute()) {
                        $success = "Your password has been reset successfully!";
                    } else {
                        $error = "An error occurred while resetting your password.";
                    }
                    $stmt->close();
                } else {
                    $error = "No account found with this email!";
                }
            }
        } else {
            $error = "Passwords do not match!";
        }
    } else {
        $error = "Please fill in all fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReflectaHome - Sign Up / Sign In</title>
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

    <!-- Sign Up / Sign In Section -->
    <section class="signup-in-section">
        <div class="signup-in-content">
            <div class="signup-in-card">
                <!-- ReflectaHome Logo -->
                <div class="logo-container text-center">
                    <img src="/ReflectaHome/Images/logo-no-background.png" alt="ReflectaHome Logo" class="logo">
                </div>

                <!-- Login Form -->
                <div id="loginForm">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100">Sign In</button>
                    </form>

                    <!-- Display error message if any -->
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger mt-3">
                            <?= $error; ?>
                        </div>
                    <?php endif; ?>

                    <div class="toggle-btn">
                        <p>Don't have an account? <a href="#" id="createAccountLink">Create an Account</a></p>
                    </div>

                    <div class="toggle-btn">
                        <p><a href="#" id="forgotPasswordLink">Forgot Password?</a></p>
                    </div>
                </div>

                <!-- Lost Password Form -->
                <div id="forgotPasswordForm" style="display:none;">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                        </div>
                        <button type="submit" name="resetPassword" class="btn btn-primary w-100">Reset Password</button>
                    </form>

                    <!-- Display error or success message if any -->
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger mt-3">
                            <?= $error; ?>
                        </div>
                    <?php elseif (isset($success)) : ?>
                        <div class="alert alert-success mt-3">
                            <?= $success; ?>
                        </div>
                    <?php endif; ?>

                    <div class="toggle-btn">
                        <p><a href="#" id="backToSignInLink">Back to Sign In</a></p>
                    </div>
                </div>

                <!-- Registration Form (Initially hidden) -->
                <div id="registerForm" style="display:none;">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" placeholder="Enter your address" required></textarea>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="agree" name="agree">
                            <label class="form-check-label" for="agree">I agree to ReflectaHome's <a href="/terms.html">Privacy Policy</a> and <a href="/terms.html">Terms of Service</a>.</label>
                        </div>

                        <button type="submit" name="register" class="btn btn-primary w-100">Create Account</button>
                    </form>

                    <!-- Display error message if any -->
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger mt-3">
                            <?= $error; ?>
                        </div>
                    <?php endif; ?>

                    <div class="toggle-btn">
                        <p>Already have an account? <a href="#" id="signInLink">Sign In</a></p>
                    </div>
                </div>
            </div>
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

    <!-- External JavaScript file -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle between login, register, and forgot password forms
        document.getElementById("createAccountLink").addEventListener("click", function(e) {
            e.preventDefault();
            document.getElementById("loginForm").style.display = "none";
            document.getElementById("registerForm").style.display = "block";
        });

        document.getElementById("signInLink").addEventListener("click", function(e) {
            e.preventDefault();
            document.getElementById("loginForm").style.display = "block";
            document.getElementById("registerForm").style.display = "none";
        });

        document.getElementById("forgotPasswordLink").addEventListener("click", function(e) {
            e.preventDefault();
            document.getElementById("loginForm").style.display = "none";
            document.getElementById("forgotPasswordForm").style.display = "block";
        });

        document.getElementById("backToSignInLink").addEventListener("click", function(e) {
            e.preventDefault();
            document.getElementById("forgotPasswordForm").style.display = "none";
            document.getElementById("loginForm").style.display = "block";
        });
    </script>
</body>
</html>
