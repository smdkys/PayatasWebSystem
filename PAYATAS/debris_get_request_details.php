<?php
// Ensure proper error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set headers to ensure UTF-8 encoding
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Include database connection
include_once("connections/connection.php");

// Function to safely encode JSON and handle encoding errors
function safeJsonEncode($data) {
    // Attempt to fix encoding issues
    array_walk_recursive($data, function(&$value) {
        // Replace invalid UTF-8 characters
        if (is_string($value)) {
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        }
    });

    // Encode with error handling
    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
    
    if ($json === false) {
        // Log the specific encoding error
        error_log('JSON Encoding Error: ' . json_last_error_msg());
        
        // Return a sanitized version
        return json_encode([
            'error' => 'JSON Encoding Failed',
            'debug_data' => array_map(function($value) {
                return is_string($value) ? mb_convert_encoding($value, 'UTF-8', 'UTF-8') : $value;
            }, $data)
        ]);
    }
    
    return $json;
}

// Check database connection
$con = connection();
if (!$con) {
    die(safeJsonEncode(['error' => "Database connection failed: " . mysqli_connect_error()]));
}

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die(safeJsonEncode(['error' => "Invalid or missing ID"]));
}

$id = intval($_GET['id']);

// Prepare and execute query
$sql = "SELECT * FROM debrisform WHERE id = ?";
$stmt = $con->prepare($sql);

if (!$stmt) {
    die(safeJsonEncode(['error' => "Prepare statement failed: " . $con->error]));
}

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if (!$result) {
    die(safeJsonEncode(['error' => "Query execution failed: " . $stmt->error]));
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Ensure each field is properly encoded
    foreach ($row as &$value) {
        if (is_string($value)) {
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        }
    }
    
    // Output the safely encoded JSON
    echo safeJsonEncode($row);
} else {
    echo safeJsonEncode(['error' => "No request found for ID: " . $id]);
}

$stmt->close();
$con->close();
?>