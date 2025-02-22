<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

// Include the configuration file
require_once '../config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $sell_id = intval($_POST['sell_id']);
    $flat_no = htmlspecialchars($_POST['flat_no']);
    $project_id = intval($_POST['project_id']);

    // Validate form data
    if (empty($flat_no) || empty($project_id)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        // Prepare and execute the SQL statement to update the sell
        try {
            $stmt = $conn->prepare("UPDATE flats SET flat_no = :flat_no, project_id = :project_id WHERE id = :id");
            $stmt->bindParam(':flat_no', $flat_no);
            $stmt->bindParam(':project_id', $project_id);
            $stmt->bindParam(':id', $sell_id, PDO::PARAM_INT);
            $stmt->execute();

            // Redirect to the sell page with a success message
            header('Location: /e-real-estate/pages/sell.php?status=success');
            exit();
        } catch (PDOException $e) {
            // Handle database errors
            die("Error: " . $e->getMessage());
        }
    }
} else {
    // If the form is not submitted, redirect to the sell page
    header('Location: /e-real-estate/pages/sell.php');
    exit();
}
?>