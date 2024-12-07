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
    $min_price = isset($_GET['min']) ? floatval($_GET['min']) : 0;
    $max_price = isset($_GET['max']) ? floatval($_GET['max']) : PHP_FLOAT_MAX;

    // Filter vehicles by price range
    $sql = "SELECT * FROM vehicles WHERE price BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dd", $min_price, $max_price);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $vehicles = array();
        while($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }
        echo json_encode($vehicles);
    } else {
        throw new Exception("Error filtering vehicles: " . $conn->error);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>