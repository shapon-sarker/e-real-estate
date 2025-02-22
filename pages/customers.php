<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

include '../includes/header.php';
include '../config.php';

// Fetch all customers with project and flat details
$stmt = $conn->query("
    SELECT customers.*, projects.project_name, flats.flat_no
    FROM customers
    JOIN projects ON customers.project_id = projects.id
    JOIN flats ON customers.flat_id = flats.id
");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container fade-in">
    <h1 class="text-center my-4">Customers</h1>
    <a href="add_customer.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Add New Customer</a>

    <!-- Customer List -->
    <?php if (empty($customers)): ?>
        <div class="alert alert-info">No customers found.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Project Name</th>
                    <th>Flat No</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($customer['id']); ?></td>
                    <td><?php echo htmlspecialchars($customer['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($customer['project_name']); ?></td>
                    <td><?php echo htmlspecialchars($customer['flat_no']); ?></td>
                    <td>
                        <a href="edit_customer.php?id=<?php echo htmlspecialchars($customer['id']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                        <a href="delete_customer.php?id=<?php echo htmlspecialchars($customer['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this customer?');"><i class="fas fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>