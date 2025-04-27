<?php
session_start();

include_once("connections/connection.php");

$con = connection();

if(!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM reports_list ORDER BY id DESC";
$request = $con->query($sql);

// Check if query was successful
if(!$request) {
    die("Query failed: " . $con->error);
}

// Check if there are any rows returned
if($request->num_rows > 0) {
    $row = $request->fetch_assoc();
} else {
    $row = null; // Set $row to null if no results
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/admin.js"></script>

    <title>ADMIN PAGE</title>
</head>
<body>
    <header>
        <div class="header">
            <div class="title">
                <h1>Barangay Payatas</h1>
                <p>Environmental Police Department</p>
            </div>
            <div class="nav-links">
                <a href="" class="nav-link active">Requests</a>
                <a href="" class="nav-link">Archives</a>
            </div>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search..." class="search-input">
                <button type="submit" class="search-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="search-icon" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
                <div class="profile-menu">
                    <div class="hamburger-menu" id="profileMenuToggle">
                        ☰ 
                    </div>
                    <div class="dropdown-menu hidden" id="profileDropdown">
                        <p>WELCOME 
                            <?php echo isset($_SESSION['UserLogin']) ? $_SESSION['UserLogin'] : "Guest"; ?>
                        </p>
                        <a href="logout.php" class="logout-btn">Logout</a>
                    </div>
                </div>
        </div>
    </header>

    <div class="forms">
        <a href="admin.php" class="link  active">All Forms</a>
        <a href="spray.php" class="link">Spray</a>
        <a href="puno.php" class="link">Team Puno</a>
        <a href="kanal.php" class="link">Linis Kanal</a>
        <a href="dogcare.php" class="link">Dog Care</a>
        <a href="livelihood.php" class="link">Livelihood</a>
        <a href="debris.php" class="link">Debris</a>
    </div>

    <div class="container">
        <h2>Service Request - All Forms</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Area</th>
                    <th>Street</th>
                    <th>Landmark</th>
                    <th>ID Image</th>
                </tr>
            </thead>
            <tbody name="formdata" id="formData">
                <?php 
                // Check if we have data to display
                if($row) {
                    // Start displaying current row
                    do { 
                ?>
                <tr class="data-row">
                    <td><?php echo $row['f_name'] . " " . $row['l_name']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td><?php echo $row['area']; ?></td>
                    <td><?php echo $row['street']; ?></td>
                    <td><?php echo $row['add_info']; ?></td>
                    <td><img src="image.php?id=<?php echo $row['id']; ?>" width="150px" height="auto" /></td>
                </tr>
                <?php 
                    } while($row = $request->fetch_assoc());
                } else {
                    // Display a message if no data
                    echo '<tr><td colspan="6" style="text-align:center;">No records found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>