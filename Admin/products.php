<?php
// Include the database connection file
include_once 'db-inc.php';

// Fetch all products from the database
function getAllProducts($dbConnection) {
    $sql = "SELECT * FROM products"; // Assuming 'products' is the table name in your database
    $result = mysqli_query($dbConnection, $sql);
    $products = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
    return $products;
}

// Add a new product to the database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $name = $_POST['product-name'];
    $price = $_POST['product-price'];
    $category = $_POST['product-category'];
    $description = $_POST['product-description'];
    $image = $_FILES['product-image']['name'];

    // Move the uploaded image to the correct directory
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['product-image']['tmp_name'], $target_file);

    $sql = "INSERT INTO products (name, price, category, description, image) 
            VALUES ('$name', '$price', '$category', '$description', '$image')";
    mysqli_query($dbConnection, $sql);
}

// Edit an existing product in the database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $product_id = $_POST['product-id'];
    $name = $_POST['product-name'];
    $price = $_POST['product-price'];
    $category = $_POST['product-category'];
    $description = $_POST['product-description'];
    $image = $_FILES['product-image']['name'];

    // Move the uploaded image to the correct directory if a new image is uploaded
    if ($image) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['product-image']['tmp_name'], $target_file);
    } else {
        // If no image is uploaded, retain the current image
        $sql = "SELECT image FROM products WHERE id = '$product_id'";
        $result = mysqli_query($dbConnection, $sql);
        $row = mysqli_fetch_assoc($result);
        $image = $row['image'];
    }

    $sql = "UPDATE products SET name='$name', price='$price', category='$category', description='$description', image='$image' 
            WHERE id='$product_id'";
    mysqli_query($dbConnection, $sql);
}

// Delete a product from the database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $product_id = $_POST['product-id'];
    $sql = "DELETE FROM products WHERE id = '$product_id'";
    mysqli_query($dbConnection, $sql);
}
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
                    <a class="nav-link" href="website.php"><i class="fas fa-globe"></i> website</a>
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
        <strong>You are currently managing Products!</strong>
    </div>
</div>

  <header>
      <h2>Store Product</h2> <br>
      <!-- Filter buttons for selecting product categories -->
      <div class="filters">
          <button class="filter-btn" data-category="all">All</button>  <!-- Button to show all categories -->
          <button class="filter-btn" data-category="round">Round</button>   <!-- Button to filter by round mirrors -->
          <button class="filter-btn" data-category="square">Square</button>  <!-- Button to filter by square mirrors -->
          <button class="filter-btn" data-category="customized">Customized</button>   <!-- Button to filter by customized mirrors -->
      </div>
  </header>
  
  <main id="products" class="gallery">
      <!-- Placeholder for dynamically loaded products -->
      <?php
      // Fetch products from the database and display them
      $products = getAllProducts($dbConnection);
      foreach ($products as $product) {
          echo "
          <div class='gallery-item {$product['category']}'>
            <div class='card'>
                <img src='images/{$product['image']}' alt='{$product['name']}'>
                <div class='card-overlay'>
                    <p>{$product['name']}</p>
                </div>
                <div class='card-content'>
                    <h3>R{$product['price']}</h3>
                    <p class='category'>{$product['category']}</p>
                    <p class='description'>{$product['description']}</p>
                    <div class='buttons'>
                        <button class='edit-btn' data-bs-toggle='modal' data-bs-target='#product-modal' data-id='{$product['id']}' data-name='{$product['name']}' data-price='{$product['price']}' data-category='{$product['category']}' data-description='{$product['description']}' data-image='{$product['image']}'>Edit</button>
                        <form method='POST'>
                            <input type='hidden' name='product-id' value='{$product['id']}'>
                            <button type='submit' name='action' value='delete' class='delete-btn'>Delete</button>
                        </form>
                    </div>
                </div>
            </div>
          </div>";
      }
      ?>
  </main>

  <!-- Add New Product Button -->
  <div class="add-new-btn">
      <button id="add-new-product-btn" data-bs-toggle="modal" data-bs-target="#product-modal">Add New Product</button>
  </div>

  <!-- Add/Edit Product Modal -->
  <div class="modal" id="product-modal" tabindex="-1">
      <div class="modal-dialog">
          <div class="modal-content">
              <span class="close-modal" id="close-modal">&times;</span>
              <h2 id="modal-title">Add New Product</h2>
              <form id="product-form" action="products.php" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="action" value="add" id="modal-action">
                  <input type="hidden" name="product-id" id="product-id">
                  
                  <label for="product-name">Product Name:</label>
                  <input type="text" name="product-name" id="product-name" required><br>

                  <label for="product-price">Price (R):</label>
                  <input type="number" name="product-price" id="product-price" required><br>

                  <label for="product-category">Category:</label>
                  <select name="product-category" id="product-category">
                      <option value="round">Round</option>
                      <option value="square">Square</option>
                      <option value="customized">Customized</option>
                  </select><br>

                  <label for="product-description">Description:</label>
                  <textarea name="product-description" id="product-description" required></textarea><br>

                  <label for="product-image">Product Image:</label>
                  <input type="file" name="product-image" id="product-image" accept="image/*"><br>

                  <button type="submit">Save Product</button>
              </form>
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

<script>
// JavaScript to handle modal pre-filling for editing
const editButtons = document.querySelectorAll('.edit-btn');
const modalTitle = document.getElementById('modal-title');
const productForm = document.getElementById('product-form');

editButtons.forEach(button => {
    button.addEventListener('click', () => {
        const productId = button.getAttribute('data-id');
        const productName = button.getAttribute('data-name');
        const productPrice = button.getAttribute('data-price');
        const productCategory = button.getAttribute('data-category');
        const productDescription = button.getAttribute('data-description');
        const productImage = button.getAttribute('data-image');
        
        document.getElementById('modal-action').value = 'edit';
        document.getElementById('product-id').value = productId;
        document.getElementById('product-name').value = productName;
        document.getElementById('product-price').value = productPrice;
        document.getElementById('product-category').value = productCategory;
        document.getElementById('product-description').value = productDescription;

        modalTitle.textContent = 'Edit Product';
    });
});

// Reset modal for add new product
const addNewProductButton = document.getElementById('add-new-product-btn');
addNewProductButton.addEventListener('click', () => {
    document.getElementById('modal-action').value = 'add';
    document.getElementById('product-id').value = '';
    document.getElementById('product-name').value = '';
    document.getElementById('product-price').value = '';
    document.getElementById('product-category').value = 'round';
    document.getElementById('product-description').value = '';
    modalTitle.textContent = 'Add New Product';
});
</script>
</body>
</html>
