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

// Include the header
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Project - eRealEstate</title>
    <link rel="stylesheet" href="/e-real-estate/assets/css/styles.css">
</head>
<body>
    <div class="admin-container">
        <h1>Add New Project</h1>
        <div class="admin-menu">
            <?php include '../includes/admin_sidebar.php'; ?> <!-- Move admin menu to a separate file -->
        </div>
        <div class="admin-content">
            <h2>Add Project Form</h2>
            <form action="process_add_project.php" method="POST">
                <div class="form-group">
                    <label for="project_name">Project Name:</label>
                    <input type="text" id="project_name" name="project_name" required>
                </div>
                <div class="form-group">
                    <label for="project_description">Description:</label>
                    <textarea id="project_description" name="project_description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="project_location">Location:</label>
                    <input type="text" id="project_location" name="project_location" required>
                </div>
                <div class="form-group">
                    <label for="project_price">Price:</label>
                    <input type="number" id="project_price" name="project_price" required>
                </div>
                <div class="form-group">
                    <button type="submit">Add Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include the footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>