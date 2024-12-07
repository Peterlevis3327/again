<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Include database connection
require_once 'config.php';

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Get all vehicles
    $sql = "SELECT * FROM vehicles";
    $result = $conn->query($sql);

    if ($result) {
        $vehicles = array();
        while($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }
        echo json_encode($vehicles);
    } else {
        throw new Exception("Error fetching vehicles: " . $conn->error);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>