<?php

include_once("connections/connection.php");

$con = connection();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/homepage.css">
    <script src=""></script>

    <title>Welcome to Barangay Payatas</title>

    <style>
        /* General modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            width: 300px;
        }

        .modal button {
            padding: 10px 15px;
            margin: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-yes {
            background: #28a745;
            color: white;
            border-radius: 5px;
        }

        .btn-no {
            background: #dc3545;
            color: white;
            border-radius: 5px;
        }
    </style>

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
                <li><a href="services.php" class="active">Services</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
            </ul>
        </nav>
    </div>
    </header>
    <div class="tite">
            <h1>Services</h1>
        </div>

    <div class="services">
        <button class="service-box" onclick="location.href='sprayform.php'"><img src="img/Spray.png" alt="Spray"></br>Spray</button>
        <button class="service-box" onclick="location.href='punoform.php'"><img src="img/Puno.png" alt="Team Puno"></br>Team Puno</button>
        <button class="service-box" onclick="location.href='kanalform.php'"><img src="img/LinisKanal.png" alt="Linis Kanal"></br>Linis Kanal</button>
        <button class="service-box" onclick="openDogCareModal()"><img src="img/Dog care.png" alt="Dog Care"></br>Dog Care</button>
        <button class="service-box" onclick="openLivelihoodModal()"><img src="img/Livelyhood.png" alt="Livelihood"></br>Livelihood</button>
        <button class="service-box" onclick="location.href='debrisform.php'"><img src="img/Debris.png" alt="Debris"></br>Debris</button>
    </div>


    <div id="dogCareModal" class="modals">
        <div class="modal-content">
            <h3>Please select a type of service.</h3>
            <div class="modal-buttons">
                <button class="btn-petsit" onclick="redirectTo('petsitform.php')">Pet-sit</button>
                <button class="btn-turnin" onclick="redirectTo('turninform.php')">Turn-in</button>
            </div>
        </div>
    </div>

        <!-- Livelihood Modal -->
    <div id="livelihoodModal" class="modal">
        <div class="modal-content">
            <h3>Please select a type of livelihood service.</h3>
            <div class="modal-buttons">
                <button class="btn-livelihood" onclick="redirectTo('lhoffsiteform.php')">Offsite</button>
                <button class="btn-turnin" onclick="redirectTo('lhonsiteform.php')">Onsite</button>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer">
            <p>&copy; 2025 Barangay Payatas Environmental Police Department</p>
            <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
        </div>
    </footer>



    <script>
        function openModal(event) {
            event.preventDefault(); // Stop form from submitting immediately
            document.getElementById("confirmModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("confirmModal").style.display = "none";
        }

        function submitForm() {
            sessionStorage.setItem("submitted", "true");
            document.getElementById("myForm").submit(); // Manually submit form
        }

        function closeSuccessModal() {
        document.getElementById("successModal").style.display = "none";
    }

    // Show success modal after redirection **only after submission**
    window.onload = function() {
        if (sessionStorage.getItem("submitted") === "true") {
            document.getElementById("successModal").style.display = "flex";
            
            // Customize the success message
            document.getElementById("successMessage").innerText = "We have received your request. Thankyou for providing the necessary details.";
            
            sessionStorage.removeItem("submitted"); // Remove flag to prevent pop-up on refresh
        }
    };

    function openDogCareModal() {
        document.getElementById("dogCareModal").style.display = "flex";
    }

    function closeDogCareModal() {
        document.getElementById("dogCareModal").style.display = "none";
    }
    function openLivelihoodModal() {
        document.getElementById("livelihoodModal").style.display = "flex";
    }

    function closeLivelihoodModal() {
        document.getElementById("livelihoodModal").style.display = "none";
    }

    function redirectTo(page) {
        window.location.href = page; // Redirect to selected service page
    }
    window.onclick = function(event) {
        // Get all modal elements
        const modals = document.querySelectorAll(".modal, .modals");

        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    };
</script>

        <!-- Success Modal -->
        <div id="successModal" class="modal">
            <div class="modal-content">
                <p id="successMessage">We have received your request. Thankyou for providing the necessary details.</p> <!-- Customizable message -->
                <button class="btn-yes" onclick="closeSuccessModal()">OK</button>
            </div>
        </div>

    
</body>
</html>