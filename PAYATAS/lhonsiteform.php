<?php

include_once("connections/connection.php");

$con = connection();

if(isset($_POST["submit"])){

    $date = $_POST["date"];
    $time = $_POST["time"];
    $program_type = $_POST["program_type"];
    $participants = $_POST["participants"];
    $location = $_POST["location"];
    $fullname = $_POST["fullname"];
    $contact = $_POST["contact"];

    // Ensure at least one image is uploaded
    if(isset($_FILES['file1']) && $_FILES['file1']['error'] === UPLOAD_ERR_OK) {
        $image1 = file_get_contents($_FILES['file1']['tmp_name']);
    } else {
        die("Error: You must upload at least one image for 'photo'.");
    }

    if(isset($_FILES['file2']) && $_FILES['file2']['error'] === UPLOAD_ERR_OK) {
        $image2 = file_get_contents($_FILES['file2']['tmp_name']);
    } else {
        $image2 = NULL; // Second image is optional
    }

    $sql = "INSERT INTO `livelihoodonsiteform`(`date`, `time`, `program_type`, `participants`, `location`, `fullname`, `contact`, `photo`, `photo2`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    
    $stmt->bind_param("sssssssss", $date, $time, $program_type, $participants, $location, $fullname, $contact, $image1, $image2);
    
    // Send image data
    $stmt->send_long_data(7, $image1); // Photo (Required)
    if ($image2 !== NULL) {
        $stmt->send_long_data(8, $image2); // Photo2 (Optional)
    }

    if ($stmt->execute()) {
        $stmt->close();
        echo "<script>
                sessionStorage.setItem('submitted', 'true');
                window.location.href = 'services.php';
              </script>";
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/lamok.css">
    <script src="js/formspage.js"></script>
    <title>Livelihood - Onsite</title>

    <style>
        .datetime-group {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .datetime-group input[type="date"],
        .datetime-group input[type="time"] {
            flex: 1;
            min-width: 0;
        }

        /* Make all input fields same width */
        input[type="text"], input[type="file"], input[type="date"], input[type="time"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #d0d0d0;
            border-radius: 20px;
            outline: none;
            font-family: 'Poppins', sans-serif;
            color: #333;
            background-color: white;
            box-sizing: border-box;
        }


        /* Additional styles for date and time inputs */
        input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #d0d0d0;
            border-radius: 20px;
            outline: none;
            font-family: 'Poppins', sans-serif;
            color: #333;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>') no-repeat right 10px center;
            background-size: 24px;
            background-color: white;
            cursor: pointer;
        }

        /* For the placeholder effect */
        input[type="date"]:invalid, input[type="time"]:invalid {
            color: #757575;
        }
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

        #preview1, #preview2 {
            max-width: 200px;
            margin-top: 10px;
            display: none;
            margin-left: auto;
            margin-right: auto;
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
                <li><a href="services.php">Cancel</a></li>
                <li><a href="services.php" class="active">Services</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
            </ul>
        </nav>
    </div>
    </header>

    <form id="myform" method="post" enctype="multipart/form-data">
        <div class="container">
            <h2>Livelihood - Onsite</h2>
            <h5>Please fill out the form below to request service from our team. This helps us understand your needs better.</h5>
            
            <!-- Date and Time Inputs -->
            <label>Date/Time</label>
            <div class="datetime-group">
                <input type="date" name="date" id="date" required>
                
                <input type="time" name="time" id="time" required>
            </div>

            <!-- Program Type Dropdown -->
            <label for="program_type">Type of Program</label>
            <select name="program_type" id="program_type" required>
                <option value="" disabled selected hidden>Select a Program</option>
                <option>Dishwashing liquid making</option>
                <option>Perfume Making</option>
                <option>Rugs Making</option>
                <option>Sublimation</option>
                <option>Baking</option>
            </select>

            <!-- Participants and Location -->
            <label for="participants">Number of Participants</label>
            <input type="number" name="participants" id="participants" placeholder="Enter the number of participants" min="0" required>

            <label for="location">Location Address</label>
            <input type="text" name="location" id="location" placeholder="Enter the location address" required>

            <!-- Personal Information -->
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" id="fullname" placeholder="Enter your Full Name" required>

            <input type="text" name="contact" required pattern="^[0-9]+$" maxlength="11" title="Numbers only, up to 11 digits" placeholder="Enter your Contact Number" required>

            <!-- File Upload Section -->
            <div class="file-upload" onclick="document.getElementById('file1').click();">
                + Attach a photo of your request letter 
                <input type="file" name="file1" id="file1" style="display:none;" accept="image/*" onchange="previewFile1()">
                <img id="preview1" alt="Preview Image">
            </div>

            <div class="file-upload" onclick="document.getElementById('file2').click();">
                + Attach a photo of your Valid ID (JPG, PNG, GIF)
                <input type="file" name="file2" id="file2" style="display:none;" accept="image/*" onchange="previewFile2()">
                <img id="preview2" alt="Preview Image">
            </div>

            <div class="checkbox_container">
                <input type="checkbox" id="declaration" required>
                <label for="declaration">I hereby declare that the information and documents attached are accurate, factual, and true to the best of my knowledge.</label>
            </div>

            <div class="buttons">
                <button type="button" class="clear" onclick="clearForm()">Clear All</button>
                <button type="button" class="submit" onclick="openModal()">Submit Form</button>
            </div>
        </div> 
        
        <!-- Confirmation Modal -->
        <div id="confirmModal" class="modal">
            <div class="modal-content">
                <p>Submit all information?<br>
                Please ensure that everything is correct before proceeding.</p>
                <button class="btn-no" type="button" onclick="closeModal()">No</button>
                <button class="btn-yes" type="submit" name="submit" onclick="closeModal()">Yes</button>
            </div>
        </div>
    </form>

    <footer>
        <div class="footer">
            <p>&copy; 2025 Barangay Payatas Environmental Police Department</p>
            <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
        </div>
    </footer>

    <script>
        // Add placeholder text to date/time inputs
        document.addEventListener('DOMContentLoaded', function() {
            // Set min date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').min = today;
            
            // Initialize with empty values
            document.getElementById('date').value = '';
            document.getElementById('time').value = '';
        });

        function openModal() {
            const date = document.getElementById("date").value;
            const time = document.getElementById("time").value;
            const program_type = document.getElementById("program_type").value;
            const participants = document.getElementById("participants").value.trim();
            const location = document.getElementById("location").value.trim();
            const fullname = document.getElementById("fullname").value.trim();
            const contact = document.querySelector('input[name="contact"]').value.trim();
            const file1 = document.getElementById("file1").files[0];
            const declaration = document.getElementById("declaration").checked;

            if (!date || !time || !program_type || !participants || !location || !fullname || !contact || !file1 || !declaration) {
                alert("Please fill in all required fields and upload at least the request letter photo.");
                return;
            }

            document.getElementById("confirmModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("confirmModal").style.display = "none";
        }

        // Preview function for first file
        function previewFile1() {
            const preview = document.getElementById('preview1');
            const file = document.getElementById('file1').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
                preview.style.display = "block"; // Show preview
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.style.display = "none";
            }
        }
        
        // Preview function for second file
        function previewFile2() {
            const preview = document.getElementById('preview2');
            const file = document.getElementById('file2').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
                preview.style.display = "block"; // Show preview
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.style.display = "none";
            }
        }

        // Updated clear form function
        function clearForm() {
            document.getElementById("myform").reset();
            document.getElementById("preview1").style.display = 'none';
            document.getElementById("preview2").style.display = 'none';
        }

        // Show success modal after redirect
        window.onload = function() {
            if (sessionStorage.getItem("submitted") === "true") {
                alert("Form submitted successfully!");
                sessionStorage.removeItem("submitted");
            }
        };
    </script>
</body>
</html>