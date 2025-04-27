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
    <link rel="stylesheet" href="css/get.css">
    <title>Welcome to Barangay Payatas</title>
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
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
            </ul>
        </nav>
    </div>
    </header>

    <section class="leaves">
        <div class="hero-content">
            <h1>Report. Request. Protect.</h1>
            <p>Quick and easy environmental services at your fingertips.</p>
            <a href="services.php" class="btn">Get Started</a>
        </div>
    </section>


    <section class="services">
        <div class="service-card">
            <img src="img/Spray.png" alt="Spray">
            <h3>Spray</h3>
            <p>Sprays mosquito repellent in a mosquito-infested area.</p>
        </div>

        <div class="service-card">
            <img src="img/LinisKanal.png" alt="Linis Kanal">
            <h3>Linis Kanal</h3>
            <p>Cleans clogged creeks.</p>
        </div>

        <div class="service-card">
            <img src="img/Debris.png" alt="Debris">
            <h3>Debris</h3>
            <p>Removes debris, rocks, logs, and soil that blocks the road.</p>
        </div>

        <div class="service-card">
            <img src="img/Puno.png" alt="Team Puno">
            <h3>Team Puno</h3>
            <p>Trims overgrown trees.</p>
        </div>

        <div class="service-card">
            <img src="img/Dog care.png" alt="Dog Care">
            <h3>Dog Care</h3>
            <p>Offers pet sitting and takes in surrendered dogs.</p>
        </div>

        <div class="service-card">
            <img src="img/Livelyhood.png" alt="Livelihood">
            <h3>Livelihood</h3>
            <p>Offers various livelihood programs.</p>
        </div>
    </section>


    <section class="faq">
        <h2>Frequently Asked Questions</h2>

        <div class="faq-category">
            <h3>Service Requests</h3>
            <div class="faq-item">
                <button class="faq-question">How long does it take to process a service request? <span>▼</span></button>
                <div class="faq-answer">
                    <p>Service requests typically take 2-3 business days to process.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">Is there a limit to the number of service requests I can submit? <span>▼</span></button>
                <div class="faq-answer">
                    <p>No, you can submit as many service requests as needed.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">What types of service requests can I submit? <span>▼</span></button>
                <div class="faq-answer">
                    <p>You can submit requests related to cleaning, maintenance, and environmental services.</p>
                </div>
            </div>
        </div>

        <p class="help-text">Need More Help? <a href="contactus.php">Click here</a></p>

        <p class="rere">Would you like to submit a request now?</p>
        <a href="services.php" class="get-started-btn">Get Started</a>
    </section>


    <footer>
        <div class="footer">
            <p>&copy; 2025 Barangay Payatas Environmental Police Department</p>
            <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
        </div>
    </footer>

    <script>
    const images = [
        'img/getbg.jpg',
        'img/bg2.jpg',
        'img/bg3.jpg',
        'img/bg4.jpg'
    ];

    let current = 0;
const leaves = document.querySelector('.leaves');
let isTransitioning = false;

// Set initial background
leaves.style.backgroundImage = `url('${images[current]}')`;

const changeBackground = () => {
    if (isTransitioning) return; // Prevent overlapping transitions
    isTransitioning = true;

    const next = (current + 1) % images.length;
    const fadeLayer = document.createElement('div');
    fadeLayer.classList.add('fade-layer');
    fadeLayer.style.backgroundImage = `url('${images[next]}')`;

    leaves.appendChild(fadeLayer);

    // Force reflow to ensure transition works smoothly after page load
    fadeLayer.offsetHeight; // Accessing offsetHeight forces a reflow

    requestAnimationFrame(() => {
        fadeLayer.style.opacity = '1';
    });

    setTimeout(() => {
        leaves.style.backgroundImage = `url('${images[next]}')`;
        fadeLayer.remove();
        current = next;
        isTransitioning = false;
    }, 1500); // match CSS transition time
};

setTimeout(() => {
    setInterval(changeBackground, 5000); // start background changes after initial load
}, 100); // optional, give a slight delay before starting transitions




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