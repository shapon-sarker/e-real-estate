<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

// Include the configuration file
require_once '../config.php';

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID

    // Prepare and execute the delete query
    try {
        $stmt = $conn->prepare("DELETE FROM customers WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Customer deleted successfully!";
        } else {
            $_SESSION['error_message'] = "Error: Unable to delete customer.";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
} else {
    $_SESSION['error_message'] = "Error: No customer ID provided.";
}

// Redirect back to customers page
header("Location: /e-real-estate/pages/customers.php");
exit();
?>