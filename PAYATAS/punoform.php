<?php

include_once("connections/connection.php");

$con = connection();

if (isset($_POST["submit"])) {

    $area = $_POST["area"];
    $street = $_POST["street"];
    $landmark = $_POST["landmark"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $contact = $_POST["contact"];

    // Both images are required
    if (isset($_FILES['file1']) && $_FILES['file1']['error'] === UPLOAD_ERR_OK) {
        $image1 = file_get_contents($_FILES['file1']['tmp_name']);
    } else {
        die("Error: You must upload a photo for land ownership.");
    }

    if (isset($_FILES['file2']) && $_FILES['file2']['error'] === UPLOAD_ERR_OK) {
        $image2 = file_get_contents($_FILES['file2']['tmp_name']);
    } else {
        die("Error: You must upload a photo of your valid ID.");
    }

    $sql = "INSERT INTO `puno`(`area`, `street`, `landmark`, `f_name`, `l_name`, `contact`, `photo`, `photo2`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);

    $stmt->bind_param("ssssssbb", $area, $street, $landmark, $fname, $lname, $contact, $image1, $image2);

    $stmt->send_long_data(6, $image1);
    $stmt->send_long_data(7, $image2);

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
    <title>Puno</title>
    <link rel="stylesheet" href="css/lamok.css">
    <script src="js/formspage.js"></script>

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

        .file-upload img {
            max-width: 20%;
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
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
            <h2>Puno</h2>
            <label>Please enter the location</label>
            <select name="area" id="area" required>
                <option value="" disabled selected hidden>Please choose an area</option>
                <option>Payatas A</option>
                <option>Payatas B</option>
                <option>Lupang Pangako</option>
            </select>

            <input type="text" name="street" id="street" placeholder="Street" required>
            <input type="text" name="landmark" placeholder="Landmark" required>

            <label>Please enter your information</label>
            <input type="text" name="lname" placeholder="Enter your Last Name" required>
            <input type="text" name="fname" placeholder="Enter your First Name" required>
            <input type="text" name="contact" required pattern="^[0-9]+$" maxlength="11" title="Numbers only, up to 11 digits" placeholder="Contact number" required>

            <div class="file-upload" onclick="document.getElementById('file1').click();">
                + Attach a photo that provides ownership for the land where the tree is located
                <input type="file" name="file1" id="file1" style="display:none;" accept="image/*" required onchange="previewFile1()">
                <img id="preview1" alt="Preview Image">
            </div>

            <div class="file-upload" onclick="document.getElementById('file2').click();">
                + Attach a photo of your Valid ID <br> Click to browse or drag and drop. (JPG, PNG, GIF only, max 5MB)
                <input type="file" name="file2" id="file2" style="display:none;" accept="image/*" required onchange="previewFile2()">
                <img id="preview2" alt="Preview Image">
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

        <div id="confirmModal" class="modal">
            <div class="modal-content">
                <p>Submit all information?<br>
                Please ensure that everything is correct before proceeding.</p>
                <button class="btn-no" type="button" onclick="closeModal()">No</button>
                <button class="btn-yes" type="submit" name="submit" form="myform">Yes</button>
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
            const street = document.getElementById("street").value.trim();
            const landmark = document.querySelector('input[name="landmark"]').value.trim();
            const lname = document.querySelector('input[name="lname"]').value.trim();
            const fname = document.querySelector('input[name="fname"]').value.trim();
            const contact = document.querySelector('input[name="contact"]').value.trim();
            const file1 = document.getElementById("file1").files[0];
            const file2 = document.getElementById("file2").files[0];
            const declaration = document.getElementById("declaration").checked;

            if (!area || !street || !landmark || !lname || !fname || !contact || !file1 || !file2 || !declaration) {
                alert("Please fill in all required fields and upload both required images.");
                return;
            }

            document.getElementById("confirmModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("confirmModal").style.display = "none";
        }

        function clearForm() {
            document.getElementById("myform").reset();
            document.getElementById("preview1").style.display = "none";
            document.getElementById("preview2").style.display = "none";
        }

        function previewFile1() {
            const file = document.getElementById('file1').files[0];
            const preview = document.getElementById('preview1');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        function previewFile2() {
            const file = document.getElementById('file2').files[0];
            const preview = document.getElementById('preview2');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
        window.onload = function () {
            if (sessionStorage.getItem("submitted") === "true") {
                alert("Form submitted successfully!");
                sessionStorage.removeItem("submitted");
            }
        };
    </script>
</body>
</html>
