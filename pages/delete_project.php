<?php
// Start the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php'); // Redirect to login page if not logged in
    exit();
}

// Include the configuration file
require_once '../config.php';

// Check if the project ID is provided in the URL
if (!isset($_GET['id'])) {
    header('Location: /e-real-estate/pages/projects.php'); // Redirect if no ID is provided
    exit();
}

$project_id = intval($_GET['id']);

// Delete the project from the database
try {
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = :id");
    $stmt->bindParam(':id', $project_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect to the projects page with a success message
    header('Location: /e-real-estate/pages/projects.php?status=deleted');
    exit();
} catch (PDOException $e) {
    // Handle database errors
    die("Error: " . $e->getMessage());
}
?>