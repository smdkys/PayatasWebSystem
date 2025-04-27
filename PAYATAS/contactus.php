<?php

if ( ! isset($_SESSION) ){
    session_start();
}

include_once("connections/connection.php");
$con = connection();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/contactus.css">
    <title>Contact Us</title>
</head>

<body>
    <header>
        <div class="header">
        <div class="title">
            <h1>Barangay Payatas</h1>
            <p>Environmental Police Department</p>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="contactus.php" class="active">Contact Us</a></li>
            </ul>
        </nav>
    </div>
    </header>

    <section class="leaves">
    <div class="container">
        <h1>Help Made Simple</h1>
        <p class="subtitle">Quick, easy, and hassle-free assistance anytime you need it.</p>
        
        <div class="services">
            <div class="service-box">
                <h2 class="service-title">Questions?</h2>
                <p class="service-detail">Call us: +1 123 456 789</p>
                <p class="service-note">We're here to help.</p>
            </div>
            
            <div class="service-box">
                <h2 class="service-title">Prefer to write?</h2>
                <p class="service-detail">Email us: support@domain.com</p>
                <p class="service-note">We'll respond within 24 hours.</p>
            </div>
            
            <div class="service-box">
                <h2 class="service-title">Open Hours</h2>
                <p class="service-detail">Monday to Friday, 9 AM - 5 PM</p>
                <p class="service-note">Excluding public holidays.</p>
            </div>
        </div>
    </div>
    </section>

    <section class="Privacy">
        <h1>Privacy Policy</h1>
            
            <div class="policy-intro">
                <p>Welcome to the Rangitay Environmental Police's Service Request Website. Your privacy is important to us.<br>
                This Privacy Policy address how we collect, use, store, and protect your personal data when using our services.</p>
            </div>
            
            <div class="section">
                <h2>Information We Collect</h2>
                <p>We collect the following types of data when you use our System:</p>
                
                <p class="data-category"><strong>Personal Information:</strong> Full name, contact number, and address.</p>
                <p class="data-category"><strong>Request Details:</strong> Type of service request, descriptions, and uploaded images.</p>
                <p class="data-category"><strong>Tracking Information:</strong> Status updates and request history.</p>
                <p class="data-category"><strong>System Data:</strong> IP address, browser type, and usage analytics.</p>
            </div>
            
            <div class="section">
                <h2>How We Use Your Information</h2>
                <p>We use your information to:</p>
                <ul>
                    <li>Process and manage your service requests.</li>
                    <li>Communicate status updates via SMS or email.</li>
                    <li>Improve our services and user experience.</li>
                    <li>Comply with legal and barangay regulations.</li>
                </ul>
            </div>
            
            <div class="section">
                <h2>Data Security</h2>
                <p>We implement industry-standard security measures to protect your data from unauthorized access, alteration, or disclosure. However, we cannot guarantee absolute security due to the nature of online systems.</p>
            </div>
            
            <div class="section">
                <h2>Sharing of Data</h2>
                <p>Your information will only be shared with:</p>
                <ul>
                    <li>Authorized barangay officers for request processing.</li>
                    <li>Third-party service providers (if necessary for request fulfillment).</li>
                    <li>Law enforcement if required by law.</li>
                </ul>
            </div>
            
            <div class="section">
                <h2>User Rights</h2>
                <p>You have the right to:</p>
                <ul>
                    <li>Access and review your submitted information.</li>
                    <li>Request corrections to inaccurate data.</li>
                    <li>Request deletion of your data (subject to legal limitations).</li>
                    <li>Withdraw consent for data processing.</li>
                </ul>
            </div>
            
            <div class="section">
                <h2>Retention of Data</h2>
                <p>We retain personal data as long as necessary for service fulfillment and legal compliance. Data no longer needed will be securely deleted.</p>
            </div>
            
            <div class="section">
                <h2>Updates to This Privacy Policy</h2>
                <p>We may update this Privacy Policy as needed. Users will be notified of any significant changes.</p>
            </div>
        </div>
    </section>

    <section class="Terms">
    <h1>Terms of Service</h1>
        
    <div class="section">
        <h2>Acceptance of Terms</h2>
        <p>By using the Barangay Environmental Police Service Request System, you agree to comply with these Terms of Use. If you do not agree, please refrain from using the System.</p>
    </div>
    
    <div class="section">
        <h2>User Responsibilities</h2>
        <p>Users must:</p>
        <ul>
            <li>Provide accurate and truthful information in service requests.</li>
            <li>Use the system responsibly and for legitimate purposes only.</li>
            <li>Refrain from submitting false or misleading requests.</li>
            <li>Respect barangay officers and service providers.</li>
        </ul>
    </div>
    
    <div class="section">
        <h2>Prohibited Activities</h2>
        <p>Users are prohibited from:</p>
        <ul>
            <li>Misusing or abusing the System.</li>
            <li>Submitting fraudulent or malicious reports.</li>
            <li>Attempting to disrupt or hack the System.</li>
            <li>Engaging in harassment or offensive behavior.</li>
        </ul>
    </div>
    
    <div class="section">
        <h2>Service Limitations</h2>
        <p>While we strive to maintain accurate and timely services, the System is provided "as is." We do not guarantee uninterrupted service or the approval of all requests.</p>
    </div>
    
    <div class="section">
        <h2>Modifications to the Service</h2>
        <p>The barangay reserves the right to modify or discontinue the System at any time without prior notice.</p>
    </div>
    
    <div class="section">
        <h2>Liability Limitation</h2>
        <p>The barangay and its officers shall not be held liable for:</p>
        <ul>
            <li>Any damages resulting from the use or inability to use the System.</li>
            <li>Unauthorized access to user data beyond our reasonable control.</li>
        </ul>
    </div>
    
    <div class="section">
        <h2>Governing Law</h2>
        <p>These Terms of Use are governed by local laws and barangay regulations. Any disputes will be handled through appropriate legal channels.</p>
    </div>
    
    <div class="section">
        <h2>Contact Information</h2>
        <p>For inquiries about these Terms or the Privacy Policy, contact us at Barangay Payatas, Bulacan Street.</p>
    </div>
</section>


    <footer>
        <div class="footer">
            <p>&copy; 2025 Barangay Payatas Environmental Police Department</p>
            <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
        </div>
    </footer>

    <script>
        document.querySelectorAll(".faq-question").forEach(button => {
        button.addEventListener("click", () => {
            button.classList.toggle("active");
            const answer = button.nextElementSibling;
            
            if (answer.style.display === "block") {
                answer.style.display = "none";
            } else {
                answer.style.display = "block";
            }
        });
    });

    </script>

    
    
</body>
</html>