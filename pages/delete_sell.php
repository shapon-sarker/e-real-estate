<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php'); // Redirect to login page if not logged in
    exit();
}

// Include the configuration file
require_once '../config.php';

// Check if the sell ID is provided in the URL
if (!isset($_GET['id'])) {
    header('Location: /e-real-estate/pages/sell.php'); // Redirect if no ID is provided
    exit();
}

$sell_id = intval($_GET['id']);

// Delete the sell from the database
try {
    $stmt = $conn->prepare("DELETE FROM flats WHERE id = :id");
    $stmt->bindParam(':id', $sell_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect to the sell page with a success message
    header('Location: /e-real-estate/pages/sell.php?status=deleted');
    exit();
} catch (PDOException $e) {
    // Handle database errors
    die("Error: " . $e->getMessage());
}
?>