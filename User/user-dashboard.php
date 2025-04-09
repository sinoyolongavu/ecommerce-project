<?php
// Database connection file
include_once 'db-inc.php';

// Fetch products from the database
$query = "SELECT * FROM products"; // Make sure you have a 'products' table in your database
$result = mysqli_query($dbConnection, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ReflectaHome - Home</title>
  <link rel="stylesheet" href="/ReflectaHome/Styles/style.css">

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
  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>Find the Perfect Mirror for Your Space</h1>
      <p>Browse our exclusive collection of mirrors to elevate your home decor.</p>
      <a href="#products" class="cta-btn">Shop Now</a>
    </div>
  </section>
  <br><br>
  <header>
    <h2>OUR MIRROR COLLECTION</h2>
    <div class="filters">
      <button class="filter-btn" data-category="all">All</button>
      <button class="filter-btn" data-category="round">Round</button>
      <button class="filter-btn" data-category="square">Square</button>
      <button class="filter-btn" data-category="customized">Customized</button>
    </div>
  </header>

  <section class="products">
    <main id="products" class="gallery">

      <?php foreach ($products as $product): ?>
        <div class="gallery-item <?php echo $product['category']; ?>">
          <div class="card">
            <img src="/ReflectaHome/Admin/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <div class="card-overlay">
              <p><?php echo $product['name']; ?></p>
            </div>
            <div class="card-content">
              <h3><?php echo 'R' . $product['price']; ?></h3>
              <p class="category"><?php echo ucfirst($product['category']); ?></p>
              <p class="description"><?php echo $product['description']; ?></p>
              <div class="buttons">
                <button class="add-to-cart">Add to Cart</button>
                <button class="add-to-wishlist">View product</button>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </main>
  </section>

  <!-- About Section -->
  <section class="about">
    <h2>About ReflectaHome</h2>
    <p>At ReflectaHome, we are passionate about transforming your home with our elegant and stylish mirrors. We offer a wide selection of mirrors designed to complement any home decor, making it easier for you to create the space of your dreams. Our mission is to provide our customers with top-quality products that enhance their living spaces.</p>

    <h3>Our Vision</h3>
    <p>We envision a world where every home is enhanced by the beauty and functionality of our mirrors. ReflectaHome strives to be the leading provider of premium mirrors, delivering excellence, innovation, and style.</p>

    <h3>Our Values</h3>
    <ul>
      <li>Quality: We deliver only the best products to our customers.</li>
      <li>Customer Satisfaction: Our customers' happiness is our priority.</li>
      <li>Innovation: We are constantly evolving to meet modern design trends.</li>
    </ul>
  </section>

  <!-- Mirror Deco Section -->
  <section class="mirror-deco">
    <h3>Transform Your Space</h3>
    <p>Explore our stunning mirror collections.</p>
    <img src="/ReflectaHome/Admin/images/collection.jpg" alt="Mirror Decoration" />
  </section>

  <!-- Contact Section -->
  <section class="contact">
    <h3>Contact Us</h3>
    <p>If you have any questions or would like to learn more about our products, feel free to contact us. We are here to help you make the perfect choice for your home.</p>

    <h4>Address</h4>
    <p>ONLY DELIVERY!<br>NO COLLECTION OR MEET UPS.<br> Business Hours<br>Monday-Friday<br> 9:30AM - 5:00PM</p>

    <h4>Email</h4>
    <p>contact@reflectahome.com</p>

    <h4>Phone</h4>
    <p>069 456 7890</p>
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

  <!-- Script: View Product Modal -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const viewButtons = document.querySelectorAll('.add-to-wishlist');
      viewButtons.forEach(button => {
        button.addEventListener('click', function (e) {
          const card = e.target.closest('.card');
          const productTitle = card.querySelector('p').textContent;
          const productPrice = card.querySelector('h3').textContent;
          const productCategory = card.querySelector('.category').textContent;
          const productDescription = card.querySelector('.description').textContent;
          const productImage = card.querySelector('img').src;
          showProductDetails(productTitle, productPrice, productCategory, productDescription, productImage);
        });
      });
    });

    function showProductDetails(title, price, category, description, image) {
      const modal = document.createElement('div');
      modal.classList.add('product-modal');
      modal.innerHTML = `
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-body">
                <img src="${image}" alt="${title}" class="modal-product-image">
                <div class="modal-product-info">
                    <h2>${title}</h2>
                    <h3>${price}</h3>
                    <p><strong>Category:</strong> ${category}</p>
                    <p><strong>Description:</strong> ${description}</p>
                </div>
            </div>
        </div>
      `;
      document.body.appendChild(modal);
      modal.querySelector('.close-modal').addEventListener('click', () => {
        document.body.removeChild(modal);
      });
      modal.style.display = 'block';
    }
  </script>

  <!-- Merged Add-to-Cart Script -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const addToCartButtons = document.querySelectorAll('.add-to-cart');
      const cartCount = document.getElementById('cart-count');

      if (!localStorage.getItem('cart')) {
        localStorage.setItem('cart', JSON.stringify([]));
      }

      function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart'));
        cartCount.textContent = cart.length;
      }

      addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
          const card = button.closest('.card');
          const productName = card.querySelector('.card-overlay p').textContent;
          const productPrice = parseFloat(card.querySelector('.card-content h3').textContent.replace('R', '').trim());
          const productCategory = card.querySelector('.card-content .category').textContent;
          const productImage = card.querySelector('img').src;
          const product = {
            name: productName,
            price: productPrice,
            category: productCategory,
            image: productImage,
            quantity: 1
          };
          const cart = JSON.parse(localStorage.getItem('cart'));
          cart.push(product);
          localStorage.setItem('cart', JSON.stringify(cart));
          updateCartCount();
          alert(product.name + " added to cart!");
        });
      });
      updateCartCount();
    });
  </script>

  <!-- Filtering functionality script -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const filterButtons = document.querySelectorAll(".filter-btn");
      const galleryItems = document.querySelectorAll(".gallery-item");
      filterButtons.forEach(button => {
        button.addEventListener("click", function () {
          const selectedCategory = button.getAttribute("data-category");
          galleryItems.forEach(item => {
            if (selectedCategory === "all") {
              item.style.display = "block";
            } else {
              item.style.display = item.classList.contains(selectedCategory) ? "block" : "none";
            }
          });
        });
      });
    });
  </script>


  <!-- Modal Structure -->
  <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="productModalLabel">Product Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="product-detail">
              <img id="modal-product-image" src="" alt="Product Image" class="img-fluid">
              <h3 id="modal-product-name"></h3>
              <p id="modal-product-description"></p>
              <h4 id="modal-product-price"></h4>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
  </div>
  
  <style>
    .product-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9999;
    }
    .modal-content {
      background-color: #fff;
      margin: 10% auto;
      padding: 20px;
      max-width: 600px;
      position: relative;
    }
    .modal-body {
      display: flex;
      align-items: center;
    }
    .modal-product-image {
      width: 150px;
      height: 150px;
      margin-right: 20px;
    }
    .modal-product-info {
      flex-grow: 1;
    }
    .close-modal {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 24px;
      cursor: pointer;
    }
    
/* General Reset for Sections */
section {
    padding: 50px 0;
    background-color: #f9f9f9;
    margin-bottom: 20px;
}

h2, h3, h4 {
    font-family: 'Arial', sans-serif;
    color: #333;
}

/* About Section */
.about {
    text-align: center;
    background-color: #ffffff;
    padding: 60px 30px;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.about h2 {
    font-size: 36px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
}

.about p {
    font-size: 18px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 20px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.about ul {
    list-style-type: none;
    padding: 0;
}

.about ul li {
    font-size: 18px;
    color: #555;
    line-height: 1.8;
    margin-bottom: 10px;
}

/* Mirror Deco Section */
.mirror-deco {
    text-align: center;
    background-color: #fff;
    padding: 60px 30px;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.mirror-deco h3 {
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 15px;
}

.mirror-deco p {
    font-size: 18px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 30px;
}

.mirror-deco img {
    width: 100%;
    max-width: 900px;
    height: auto;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

/* Contact Section */
.contact {
    text-align: center;
    background-color: #f4f4f4;
    padding: 60px 30px;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.contact h3 {
    font-size: 36px;
    font-weight: bold;
    margin-bottom: 20px;
}

.contact p {
    font-size: 18px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 30px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.contact h4 {
    font-size: 24px;
    margin-top: 20px;
    color: #333;
}

.contact .social-links {
    margin-top: 20px;
}

.contact .social-links a {
    display: inline-block;
    padding: 10px 15px;
    margin: 10px 15px;
    font-size: 18px;
    text-decoration: none;
    color: #fff;
    background-color: #333;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.contact .social-links a:hover {
    background-color: #555;
}

/* Footer Styling */
.footer {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

.footer .footer-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.footer .footer-left, .footer .footer-center, .footer .footer-right {
    width: 30%;
}

.footer .footer-left h3 {
    font-size: 24px;
    color: #fff;
}

.footer .footer-center h4, .footer .footer-right h4 {
    font-size: 20px;
    color: #fff;
}

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
    color: #fff;
}

.footer .footer-bottom {
    font-size: 14px;
    margin-top: 20px;
    color: #bbb;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .footer .footer-content {
        flex-direction: column;
        text-align: center;
    }

    .footer .footer-left, .footer .footer-center, .footer .footer-right {
        width: 100%;
        margin-bottom: 20px;
    }

    .contact h4, .about h3, .mirror-deco h3 {
        font-size: 28px;
    }

    .contact p, .about p, .mirror-deco p {
        font-size: 16px;
    }

    .contact .social-links a {
        font-size: 16px;
        padding: 8px 12px;
    }
}

.products {
    text-align: center;
    background-color: #ffffff;
    padding: 60px 30px;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}
.contact .social-links {
    margin-top: 20px;
    display: flex;               /* Make it a flex container */
    justify-content: center;     /* Center the items horizontally */
    align-items: center;         /* Align items vertically in the middle */
}

.contact .social-links a {
    display: inline-block;
    padding: 10px 15px;
    margin: 10px 15px;
    font-size: 18px;
    text-decoration: none;
    color: #fff;
    background-color: #333;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.contact .social-links a:hover {
    background-color: #555;
}

.footer .footer-right {
    text-align: center;  /* Center align the content */
    display: flex;
    flex-direction: column; /* Ensure items are stacked vertically */
    align-items: center;
}

.footer .footer-right .social-links {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.footer .footer-right .social-links a {
    margin: 0 10px; /* Adjust spacing between social icons */
}



  </style>

</body>
</html>
