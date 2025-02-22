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

// Fetch the payment details from the database
try {
    $stmt = $conn->prepare("SELECT payments.*, customers.customer_name FROM payments JOIN customers ON payments.customer_id = customers.id WHERE payments.id = :id");
    $stmt->bindParam(':id', $payment_id, PDO::PARAM_INT);
    $stmt->execute();
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$payment) {
        header('Location: /e-real-estate/pages/payments.php'); // Redirect if payment not found
        exit();
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Fetch all customers for dropdown
$customers = $conn->query("SELECT id, customer_name FROM customers")->fetchAll(PDO::FETCH_ASSOC);

// Include the header
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment - eRealEstate</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container fade-in">
        <h1 class="text-center my-4">Edit Payment</h1>

        <!-- Edit Payment Form -->
        <form action="process_edit_payment.php" method="POST">
            <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($payment['id']); ?>">
            <div class="form-group">
                <label for="customer_id">Customer:</label>
                <select class="form-control" id="customer_id" name="customer_id" required>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?php echo htmlspecialchars($customer['id']); ?>" <?php echo $customer['id'] == $payment['customer_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($customer['customer_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="mr_no">MR No:</label>
                <input type="text" class="form-control" id="mr_no" name="mr_no" value="<?php echo htmlspecialchars($payment['mr_no']); ?>" required>
            </div>
            <div class="form-group">
                <label for="payment_amount">Payment Amount:</label>
                <input type="number" step="0.01" class="form-control" id="payment_amount" name="payment_amount" value="<?php echo htmlspecialchars($payment['payment_amount']); ?>" required>
            </div>
            <div class="form-group">
                <label for="due_amount">Due Amount:</label>
                <input type="number" step="0.01" class="form-control" id="due_amount" name="due_amount" value="<?php echo htmlspecialchars($payment['due_amount']); ?>" required>
            </div>
            <div class="form-group">
                <label for="payment_date">Payment Date:</label>
                <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?php echo htmlspecialchars($payment['payment_date']); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Payment</button>
            </div>
        </form>
    </div>

    <!-- Include the footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>