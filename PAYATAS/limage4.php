<?php
include_once("connections/connection.php");

$con = connection();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure ID is an integer for security
    
    $sql = "SELECT photo2 FROM livelihoodonsiteform WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($photo2);
    $stmt->fetch();
    $stmt->close();
    
    if ($photo2) {
        header("Content-Type: image/jpeg"); // Adjust content type if needed
        echo $photo2;
    } else {
        http_response_code(404);
        echo "Image not found.";
    }
} else {
    http_response_code(400);
    echo "Invalid request.";
}
?>
