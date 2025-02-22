<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

include '../includes/header.php';
include '../config.php';

// Fetch all sales with project details
$stmt = $conn->query("
    SELECT flats.*, projects.project_name
    FROM flats
    JOIN projects ON flats.project_id = projects.id
    WHERE flats.status = 'sold'
");
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container fade-in">
    <h1 class="text-center my-4">Sell</h1>
    <a href="add_sell.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Add New Sell</a>

    <!-- Sell List -->
    <?php if (empty($sales)): ?>
        <div class="alert alert-info">No sales found.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Flat No</th>
                    <th>Project Name</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $sale): ?>
                <tr>
                    <td><?php echo htmlspecialchars($sale['id']); ?></td>
                    <td><?php echo htmlspecialchars($sale['flat_no']); ?></td>
                    <td><?php echo htmlspecialchars($sale['project_name']); ?></td>
                    <td><?php echo number_format($sale['grand_total'], 2); ?> TK</td>
                    <td>
                        <a href="edit_sell.php?id=<?php echo htmlspecialchars($sale['id']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                        <a href="delete_sell.php?id=<?php echo htmlspecialchars($sale['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this sale?');"><i class="fas fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>