<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

include '../includes/header.php';
include '../config.php';

// Fetch total sales report
$stmt = $conn->query("SELECT SUM(grand_total) as total_sales FROM flats WHERE status = 'sold'");
$total_sales = $stmt->fetch(PDO::FETCH_ASSOC)['total_sales'];

// Fetch total due report
$stmt = $conn->query("SELECT SUM(due_amount) as total_due FROM payments");
$total_due = $stmt->fetch(PDO::FETCH_ASSOC)['total_due'];
?>

<div class="container fade-in">
    <h1 class="text-center my-4">Reports</h1>

    <!-- Check if reports are available -->
    <?php if (empty($total_sales) && empty($total_due)): ?>
        <div class="alert alert-info">No reports found.</div>
    <?php else: ?>
        <div class="row">
            <!-- Total Sales Card -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Sales</h5>
                        <p class="card-text"><?php echo number_format($total_sales, 2); ?> TK</p>
                        <i class="fas fa-chart-line fa-3x text-success"></i>
                    </div>
                </div>
            </div>

            <!-- Total Due Card -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Due</h5>
                        <p class="card-text"><?php echo number_format($total_due, 2); ?> TK</p>
                        <i class="fas fa-exclamation-circle fa-3x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>