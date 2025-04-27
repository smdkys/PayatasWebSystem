<?php
include_once("connections/connection.php");
$con = connection();

if(isset($_POST["submit"])){

    $area = $_POST["area"];
    $street = $_POST["street"];
    $landmark = $_POST["landmark"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $contact = $_POST["contact"];

    if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['file']['tmp_name']);
    } else {
        $image = NULL;
    }

    $sql = "INSERT INTO `sprayform`(`area`, `street`, `landmark`, `f_name`, `l_name`, `contact`, `photo`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssss", $area, $street, $landmark, $fname, $lname, $contact, $image);

    if ($image !== NULL) {
        $stmt->send_long_data(6, $image);
    }

    if ($stmt->execute()) {
        $stmt->close();
        echo "<script>
                sessionStorage.setItem('submitted', 'true');
                window.location.href = 'services.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spray</title>
    <link rel="stylesheet" href="css/lamok.css">

    <style>
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
        <h2>Spray</h2>

        <label>Please enter the location</label>
        <select name="area" id="area" required>
            <option value="" disabled selected hidden>Please choose an area</option>
            <option>Payatas A</option>
            <option>Payatas B</option>
            <option>Lupang Pangako</option>
        </select>

        <input type="text" name="street" placeholder="Street" required>
        <input type="text" name="landmark" placeholder="Landmark" required>

        <label>Please enter your information</label>
        <input type="text" name="lname" placeholder="Enter your Last Name" required>
        <input type="text" name="fname" placeholder="Enter your First Name" required>
        <input type="text" name="contact" required pattern="^[0-9]+$" maxlength="11" title="Numbers only, up to 11 digits" placeholder="Contact number" required>

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
    function openModal() {
        const area = document.getElementById("area").value;
        const street = document.querySelector('input[name="street"]').value.trim();
        const landmark = document.querySelector('input[name="landmark"]').value.trim();
        const lname = document.querySelector('input[name="lname"]').value.trim();
        const fname = document.querySelector('input[name="fname"]').value.trim();
        const contact = document.querySelector('input[name="contact"]').value.trim();
        const file = document.getElementById("file").files[0];
        const declaration = document.getElementById("declaration").checked;

        if (!area || !street || !landmark || !lname || !fname || !contact || !file || !declaration) {
            alert("Please fill in all required fields and upload a valid ID.");
            return;
        }

        document.getElementById("confirmModal").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("confirmModal").style.display = "none";
    }

    function clearForm() {
        document.getElementById("myform").reset();
        const preview = document.getElementById("preview");
        preview.src = "";
        preview.style.display = "none"; // Hide it
    }

    function previewFile() {
        const preview = document.getElementById("preview");
        const file = document.getElementById("file").files[0];
        const reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
            preview.style.display = "block"; // Show preview
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
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
