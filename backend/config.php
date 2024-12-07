<?php
// Enable error reporting at the very top of the file
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_PORT', 3307);
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'vehicle_marketing');

try {
    // Create connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Set charset
    if (!$conn->set_charset("utf8mb4")) {
        throw new Exception("Error setting charset: " . $conn->error);
    }

    // Test the connection
    if (!$conn->ping()) {
        throw new Exception("Error: Database server is not responding");
    }

    // Database connection is successful; do not output any text here.
    // You can return a successful response in your API if necessary.
} catch (Exception $e) {
    // If any error occurs, return a JSON response with the error message
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
