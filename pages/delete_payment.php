<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

// Include the configuration file
require_once '../config.php';

// Check if the payment ID is provided in the URL
if (!isset($_GET['id'])) {
    header('Location: /e-real-estate/pages/payments.php'); // Redirect if no ID is provided
    exit();
}

$payment_id = intval($_GET['id']);

// Delete the payment from the database
try {
    $stmt = $conn->prepare("DELETE FROM payments WHERE id = :id");
    $stmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
    $stmt->execute();

    $_SESSION['success_message'] = "Payment deleted successfully!";
    header("Location: /e-real-estate/pages/payments.php");
    exit();
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Error: " . $e->getMessage();
    header("Location: /e-real-estate/pages/payments.php");
    exit();
}
?>