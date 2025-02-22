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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $project_name = htmlspecialchars($_POST['project_name']);
    $project_description = htmlspecialchars($_POST['project_description']);
    $project_location = htmlspecialchars($_POST['project_location']);
    $project_price = floatval($_POST['project_price']);

    // Prepare and execute the SQL statement
    try {
        $stmt = $conn->prepare("INSERT INTO projects (project_name, description, location, price) VALUES (:project_name, :project_description, :project_location, :project_price)");
        $stmt->bindParam(':project_name', $project_name);
        $stmt->bindParam(':project_description', $project_description);
        $stmt->bindParam(':project_location', $project_location);
        $stmt->bindParam(':project_price', $project_price);
        $stmt->execute();

        // Redirect to the projects page with a success message
        header('Location: /e-real-estate/pages/projects.php?status=success');
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        die("Error: " . $e->getMessage());
    }
} else {
    // If the form is not submitted, redirect to the add project page
    header('Location: /e-real-estate/pages/add_project.php');
    exit();
}
?>