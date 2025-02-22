<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

include '../includes/header.php';
include '../config.php';

// Fetch all payments with customer details
$stmt = $conn->query("
    SELECT payments.*, customers.customer_name
    FROM payments
    JOIN customers ON payments.customer_id = customers.id
");
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container fade-in">
    <h1 class="text-center my-4">Client Payments</h1>
    <a href="add_payment.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Add New Payment</a>

    <!-- Payments List -->
    <?php if (empty($payments)): ?>
        <div class="alert alert-info">No payments found.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>MR No</th>
                    <th>Customer Name</th>
                    <th>Payment Amount</th>
                    <th>Due Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($payment['id']); ?></td>
                    <td><?php echo htmlspecialchars($payment['mr_no']); ?></td>
                    <td><?php echo htmlspecialchars($payment['customer_name']); ?></td>
                    <td><?php echo number_format($payment['payment_amount'], 2); ?> TK</td>
                    <td><?php echo number_format($payment['due_amount'], 2); ?> TK</td>
                    <td>
                        <a href="edit_payment.php?id=<?php echo htmlspecialchars($payment['id']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                        <a href="delete_payment.php?id=<?php echo htmlspecialchars($payment['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this payment?');"><i class="fas fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>