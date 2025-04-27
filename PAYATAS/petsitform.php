<?php

include_once("connections/connection.php");

$con = connection();

if(isset($_POST["submit"])){

    $dropOffDate = $_POST["dropOffDate"];
    $dropOffTime = $_POST["dropOffTime"];
    $pickUpDate = $_POST["pickUpDate"];
    $pickUpTime = $_POST["pickUpTime"];
    $petType = $_POST["petType"];
    $dogMark = $_POST["dogMark"];  
    $fullName = $_POST["fullName"];
    $contactNumber = $_POST["contactNumber"];

    if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['file']['tmp_name']);
    } else {
        $image = NULL;
    }

    $sql = "INSERT INTO `petsitform`(`dropoffDate`, `dropoffTime`, `pickupDate`, `pickupTime`, `petType`, `dogMark`, `fullName`, `contactNumber`, `photo`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    
    $stmt->bind_param("sssssssss", $dropOffDate, $dropOffTime, $pickUpDate, $pickUpTime, $petType, $dogMark, $fullName, $contactNumber, $image);
    
    if ($image !== NULL) {
        $stmt->send_long_data(8, $image);
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
    <title>Pet Service Booking</title>

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
        
        /* Added preview styling */
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
            <h2>Dog Care - Pet-sit</h2>
            
            <label>Drop-off</label>
                <div class="datetime-group">
                    <input type="date" name="dropOffDate" id="dropOffDate" required>
                    <input type="time" name="dropOffTime" id="dropOffTime" required>
                </div>

                <label>Pick-up</label>
                <div class="datetime-group">
                    <input type="date" name="pickUpDate" id="pickUpDate" required>
                    <input type="time" name="pickUpTime" id="pickUpTime" required>
                </div>

            <label>Pet Information</label>
            <input type="text" name="petType" id="petType" placeholder="Pet Type" required>
            <input type="text" name="dogMark" id="dogMark" placeholder="Identifying Mark / Breed and Color" required>

            <label>Please enter your information</label>
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
                <button type="button" class="clear" onclick="clearForm()">Clear All</button>
                <button class="submit" type="button" onclick="openModal()">Submit Form</button>
            </div>
        </div> 
      
    </form>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <p>Submit all information?<br>
            Please ensure that everything is correct before proceeding.</p>
            <button class="btn-no" type="button" onclick="closeModal()">No</button>
            <button class="btn-yes" type="submit" name="submit" form="myform">Yes</button>
        </div>
    </div>

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
            document.getElementById('dropOffDate').min = today;
            document.getElementById('pickUpDate').min = today;
            
            // Initialize with empty values
            document.getElementById('dropOffDate').value = '';
            document.getElementById('dropOffTime').value = '';
            document.getElementById('pickUpDate').value = '';
            document.getElementById('pickUpTime').value = '';
        });

        function openModal() {
            const dropOffDate = document.getElementById("dropOffDate").value;
            const dropOffTime = document.getElementById("dropOffTime").value;
            const pickUpDate = document.getElementById("pickUpDate").value;
            const pickUpTime = document.getElementById("pickUpTime").value;
            const petType = document.getElementById("petType").value.trim();
            const dogMark = document.getElementById("dogMark").value.trim();
            const fullName = document.querySelector('input[name="fullName"]').value.trim();
            const contactNumber = document.querySelector('input[name="contactNumber"]').value.trim();
            const file = document.getElementById("file").files[0];
            const declaration = document.getElementById("declaration").checked;

            if (!dropOffDate || !dropOffTime || !pickUpDate || !pickUpTime || 
                !petType || !dogMark || !fullName || !contactNumber || !file || !declaration) {
                alert("Please fill in all required fields and upload a valid ID.");
                return;
            }

            document.getElementById("confirmModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("confirmModal").style.display = "none";
        }

        function previewFile() {
            var preview = document.getElementById('preview');
            var file = document.getElementById('file').files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.style.display = 'none';
            }
        }

        function clearForm() {
            document.getElementById("myform").reset();
            document.getElementById('preview').style.display = 'none';
        }
        
        // Show success modal after redirect
        window.onload = function() {
            if (sessionStorage.getItem("submitted") === "true") {
                alert("Form submitted successfully!");
                sessionStorage.removeItem("submitted");
            }
            
            // Set min date to today (moved from DOMContentLoaded to ensure it runs)
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('dropOffDate').min = today;
            document.getElementById('pickUpDate').min = today;
        };
    </script>
</body>
</html>