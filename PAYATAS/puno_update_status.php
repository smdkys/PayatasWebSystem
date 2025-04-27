<?php
include_once("connections/connection.php");
$con = connection();

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data['id']);
$status = $con->real_escape_string($data['status']);

$sql = "UPDATE puno SET status = '$status' WHERE id = $id";
$result = $con->query($sql);

echo json_encode(["success" => $result]);
?>
