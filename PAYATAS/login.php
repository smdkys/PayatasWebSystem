<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once("connections/connection.php");
$con = connection();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $sql = "SELECT * FROM p_admin WHERE username = ? AND password = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total = $result->num_rows;

    if ($total > 0) {
        $_SESSION['UserLogin'] = $row['username'];
        $_SESSION['Access'] = $row['password'];
        header("Location: spray.php");
        exit();
    } else {
        $error_message = "The username or password you entered is incorrect. Please try again.";
        $_SESSION['error_message'] = $error_message;
        header("Location: login.php");
        exit();
    }
}

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Admin Log-in</title>
</head>
<body>
    <div class="overlay"></div>
    <form action="" method="post">
        <div class="login-container">
            <h2>Barangay Payatas</h2>
            <p>Environmental Police Department</p>
            
            <input type="text" name="username" id="username" placeholder="Username" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            
            <?php if ($error_message): ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <button type="submit" name="login">Login</button>
        </div>
    </form>
</body>
</html>
