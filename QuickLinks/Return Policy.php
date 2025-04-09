<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReflectaHome - About Us</title>
    <link rel="stylesheet" href="/ReflectaHome/Styles/style.css"> 

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
   <!-- Go Back Link and Home Button -->
   <div class="container mt-4 d-flex justify-content-between">
    <!-- Go Back Link -->
    <a href="javascript:history.back()" class="btn btn-light"><i class="fas fa-arrow-left"></i> Go Back</a>
    
    <!-- Home Button (works as Go Back) -->
    <button id="homeButton" class="btn btn-light" onclick="goBack()">
        <i class="fas fa-home"></i> Home
    </button>
</div>
</div>


    <section class="return-section">
        <div class="container">
            <h2 class="text-center mb-4">Return Policy</h2>
            <p>At ReflectaHome, your satisfaction is our priority. If for any reason you are not completely satisfied with your purchase, we offer a straightforward return policy to ensure peace of mind:</p>
    
            <h3>1. Eligibility for Returns</h3>
            <p>We accept returns on all items that are unused, undamaged, and in their original packaging. The return request must be initiated within 14 days from the date of delivery. Once the return is approved, you can send the product back to us at your own expense. In cases where the return is due to a defect or error on our part, we will cover the return shipping costs.</p>
    
            <h3>2. How to Initiate a Return</h3>
            <p>To initiate a return, please contact our customer support team with your order number and details of the item you wish to return. We will provide you with a Return Authorization (RA) number and instructions on how to send the item back. We recommend using a trackable shipping service to ensure your return is safely received.</p>
    
            <h3>3. Refund Process</h3>
            <p>Once we receive your return in its original condition, we will process your refund within 5-7 business days. Refunds will be credited to the original payment method. Please note that shipping fees are non-refundable.</p>
    
            <h3>4. Exchanges</h3>
            <p>If you would prefer to exchange an item, we will be happy to assist. Exchanges are allowed within the 14-day return window, provided the item is in new, unused condition. Please contact our customer service team to arrange an exchange for an alternative product.</p>
    
            <h3>5. Non-Returnable Items</h3>
            <p>Some items are not eligible for return, such as personalized or custom-made products. Please review the product description carefully to ensure the item is returnable before purchasing.</p>
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
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

     <!-- Custom JavaScript for Go Back -->
     <script>
        // Function to simulate going back to the previous page
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
