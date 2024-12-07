<?php
session_start();
// Add authentication check here
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Vehicle</title>
    <link rel="stylesheet" href="admin-styles.css">
</head>
<body>
    <div class="container">
        <h1>Add New Vehicle</h1>
        <form action="/WEB%20PROJECT/backend/add_vehicle.php"  method="POST" enctype="multipart/form-data">
            <label for="type">Vehicle Type:</label>
            <input type="text" id="type" name="type" required>

            <label for="name">Vehicle Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4"></textarea>

            <button type="submit">Add Vehicle</button>
        </form>
    </div>
</body>
</html>