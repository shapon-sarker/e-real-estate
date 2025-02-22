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
    $payment_id = intval($_POST['payment_id']);
    $customer_id = intval($_POST['customer_id']);
    $mr_no = htmlspecialchars($_POST['mr_no']);
    $payment_amount = floatval($_POST['payment_amount']);
    $due_amount = floatval($_POST['due_amount']);
    $payment_date = htmlspecialchars($_POST['payment_date']);

    // Validate form data
    if (empty($customer_id) || empty($mr_no) || empty($payment_amount) || empty($payment_date)) {
        $_SESSION['error_message'] = "All fields are required.";
        header("Location: /e-real-estate/pages/edit_payment.php?id=$payment_id");
        exit();
    } else {
        // Prepare and execute the SQL statement to update the payment
        try {
            $stmt = $conn->prepare("
                UPDATE payments SET
                customer_id = :customer_id,
                mr_no = :mr_no,
                payment_amount = :payment_amount,
                due_amount = :due_amount,
                payment_date = :payment_date
                WHERE id = :id
            ");
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->bindParam(':mr_no', $mr_no);
            $stmt->bindParam(':payment_amount', $payment_amount);
            $stmt->bindParam(':due_amount', $due_amount);
            $stmt->bindParam(':payment_date', $payment_date);
            $stmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['success_message'] = "Payment updated successfully!";
            header("Location: /e-real-estate/pages/payments.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error: " . $e->getMessage();
            header("Location: /e-real-estate/pages/edit_payment.php?id=$payment_id");
            exit();
        }
    }
} else {
    // If the form is not submitted, redirect to the payments page
    header("Location: /e-real-estate/pages/payments.php");
    exit();
}
?>