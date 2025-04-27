<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("No image ID provided.");
}

include_once("connections/connection.php");
$con = connection();

$id = $_GET['id'];

$sql = "SELECT photo FROM livelihoodoffsiteform WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($imageData);
$stmt->fetch();
$stmt->close();
$con->close();

header("Content-Type: image/jpeg");
echo $imageData;
?>