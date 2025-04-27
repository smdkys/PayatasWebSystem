<?php

include_once("connections/connection.php");

$con = connection();

if(isset($_POST["submit"])){

    $date = $_POST["date"];
    $time = $_POST["time"];
    $petType = $_POST["petType"];
    $numberOfPets = $_POST["numberOfPets"];
    $dogMark = $_POST["dogMark"];  
    $fullName = $_POST["fullName"];
    $contactNumber = $_POST["contactNumber"];

    if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['file']['tmp_name']);
    } else {
        $image = NULL;
    }

    $sql = "INSERT INTO `turninform`(`date`, `time`, `petType`, `numberOfPets`, `dogMark`, `fullName`, `contactNumber`, `photo`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    
    $stmt->bind_param("ssssssss", $date, $time, $petType, $numberOfPets, $dogMark, $fullName, $contactNumber, $image);
    
    if ($image !== NULL) {
        $stmt->send_long_data(7, $image);
    }

    if ($stmt->execute()) {
        $stmt->close();
        echo "<script>
                sessionStorage.setItem('submitted', 'true');
                window.location.href = 'services.php';
              </script>";
        exit();
    } else {
        // Handle error if needed
        echo "Error: " . $stmt->error;
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
    <title>Dog Care - Turn In</title>

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

        #preview {
            max-width: 200px;
            margin-top: 10px;
            display: none;
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
            <h2>Dog Care - Turn In</h2>
            
            <label>Date/Time</label>
            <div class ="datetime-group">
                <input type="date" name="date" id="date" required>
                <input type="time" name="time" id="time" required>
            </div>

            <label>Pet Information</label>
            <input type="text" name="petType" id="petType" placeholder="Pet Type" required>
            <input type="number" name="numberOfPets" id="numberOfPets" placeholder="Number of Pets" min="0" required>

            <label>Identifying Mark / Breed and Color</label>
            <input type="text" name="dogMark" id="dogMark" placeholder="Dog Mark" required>

            <label>Your Information</label>
            <input type="text" name="fullName" placeholder="Full Name" required>
            <input type="text" name="contactNumber" required pattern="^[0-9]+$" maxlength="11" title="Numbers only, up to 11 digits" placeholder="Contact Number" required>

            <div class="file-upload" onclick="document.getElementById('file').click();">
                + Attach a photo of your Valid ID <br> Click to browse or drag and drop. (JPG, PNG, GIF only, max 5MB)
                <input type="file" name="file" id="file" style="display:none;" accept="image/*" onchange="previewFile()">
                <img id="preview" alt="Preview Image">
            </div>

            <div class="checkbox_container">
                <input type="checkbox" id="declaration" required>
                <label for="declaration">I hereby declare that the information and documents attached are accurate, factual, and true to the best of my knowledge.</label>
            </div>

            <div class="buttons">
                <button class="clear" type="button" onclick="clearForm()">Clear All</button>
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
            const petType = document.getElementById("petType").value.trim();
            const numberOfPets = document.getElementById("numberOfPets").value.trim();
            const dogMark = document.getElementById("dogMark").value.trim();
            const fullName = document.querySelector('input[name="fullName"]').value.trim();
            const contactNumber = document.querySelector('input[name="contactNumber"]').value.trim();
            const file = document.getElementById("file").files[0];
            const declaration = document.getElementById("declaration").checked;

            if (!date || !time || !petType || !numberOfPets || !dogMark || !fullName || !contactNumber || !file || !declaration) {
                alert("Please fill in all required fields and upload a valid ID.");
                return;
            }

            document.getElementById("confirmModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("confirmModal").style.display = "none";
        }

        function previewFile() {
            const preview = document.getElementById('preview');
            const file = document.getElementById('file').files[0];
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

        function clearForm() {
            document.getElementById("myform").reset();
            const preview = document.getElementById("preview");
            preview.src = "";
            preview.style.display = "none"; // Hide it
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