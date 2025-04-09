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
    <!-- Terms & Conditions Section -->
    <section class="abuse-section">
        <div class="container">
            <h2 class="text-center mb-4">Report Abuse</h2>
            <p>ReflectaHome is committed to maintaining a safe and secure shopping experience for all of our customers. If you experience or witness any form of abuse, fraud, or misconduct, we urge you to report it immediately so we can take action and ensure our community remains respectful and secure.</p>
    
            <h3>1. Types of Abuse</h3>
            <p>We take reports of abuse seriously and aim to address any situation that violates our policies or the law. This includes, but is not limited to:</p>
            <ul>
                <li><strong>Fraudulent Activity:</strong> Unauthorized use of payment methods, attempted scams, or other fraudulent behavior.</li>
                <li><strong>Harassment or Intimidation:</strong> Any form of verbal or physical abuse directed towards our staff, customers, or anyone in our community.</li>
                <li><strong>Inappropriate Content:</strong> Offensive, obscene, or discriminatory language, including hate speech, that goes against our community guidelines.</li>
                <li><strong>Violations of Terms:</strong> Any activity that breaches our terms and conditions, including but not limited to account misuse, attempts to manipulate our system, or illegal actions.</li>
            </ul>
    
            <h3>2. How to Report Abuse</h3>
            <p>If you encounter any of the above types of abuse, please contact us immediately. You can report abuse through our dedicated customer support page or directly email our support team at [insert support email]. Be sure to include relevant details, such as your order number, description of the incident, and any supporting evidence (e.g., screenshots, communications, etc.).</p>
    
            <h3>3. Investigation & Action</h3>
            <p>Once we receive your report, our team will investigate the situation thoroughly. We take all reports seriously and aim to resolve issues quickly and fairly. Depending on the severity of the case, we may take the following actions:</p>
            <ul>
                <li>Account suspension or permanent ban.</li>
                <li>Reporting the issue to the relevant authorities, if necessary.</li>
                <li>Legal action, including prosecution, if applicable.</li>
            </ul>
    
            <h3>4. Confidentiality</h3>
            <p>Your report will be treated confidentially. We respect your privacy and will only share information with necessary parties as required for the investigation or by law. Your identity will be protected to the extent possible.</p>
    
            <h3>5. Prevention of Abuse</h3>
            <p>We are continuously working to improve our security measures and prevent abuse from happening on our platform. We appreciate your help in making ReflectaHome a safe and welcoming space for everyone. If you have any concerns or need assistance, don’t hesitate to reach out to our support team.</p>
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
