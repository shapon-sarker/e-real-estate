<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

include '../includes/header.php';
include '../config.php';

// Fetch all projects
$stmt = $conn->query("SELECT * FROM projects");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all flats
$stmt = $conn->query("SELECT * FROM flats");
$flats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all payments
$stmt = $conn->query("SELECT * FROM payments");
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container fade-in">
    <h1 class="text-center my-4">Dashboard</h1>

    <!-- Quick Access Buttons -->
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <a href="projects.php" class="btn btn-primary"><i class="fas fa-project-diagram"></i> Projects</a>
            <a href="sell.php" class="btn btn-success"><i class="fas fa-hand-holding-usd"></i> Sell</a>
            <a href="customers.php" class="btn btn-info"><i class="fas fa-users"></i> Customers</a>
            <a href="payments.php" class="btn btn-warning"><i class="fas fa-credit-card"></i> Payments</a>
            <a href="reports.php" class="btn btn-danger"><i class="fas fa-chart-pie"></i> Reports</a>
        </div>
    </div>

    <!-- Project Wise Statistics -->
    <?php if (empty($projects)): ?>
        <div class="alert alert-info">No projects found.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($projects as $project): ?>
            <?php
            // Calculate project-wise statistics
            $project_id = $project['id'];
            $total_flats = $project['total_flats'];
            $sold_flats = $project['sold_flats'];
            $unsold_flats = $total_flats - $sold_flats;

            // Calculate total sell, collection, and due
            $total_sell = 0;
            $total_collection = 0;
            $total_due = 0;

            foreach ($flats as $flat) {
                if ($flat['project_id'] == $project_id && $flat['status'] == 'sold') {
                    $total_sell += $flat['grand_total'];
                }
            }

            foreach ($payments as $payment) {
                if ($payment['project_id'] == $project_id) {
                    $total_collection += $payment['payment_amount'];
                    $total_due += $payment['due_amount'];
                }
            }

            // Calculate car park statistics
            $total_car_parks = 0;
            $sold_car_parks = 0;
            $unsold_car_parks = 0;

            foreach ($flats as $flat) {
                if ($flat['project_id'] == $project_id) {
                    if ($flat['car_parking'] == 'yes') {
                        $total_car_parks++;
                        if ($flat['status'] == 'sold') {
                            $sold_car_parks++;
                        } else {
                            $unsold_car_parks++;
                        }
                    }
                }
            }
            ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($project['project_name']); ?></h5>
                        <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($project['location']); ?></p>
                        <hr>

                        <!-- Total Sell, Collection, and Due -->
                        <p><strong>Total Sell:</strong> <?php echo number_format($total_sell, 2); ?> TK</p>
                        <p><strong>Total Collection:</strong> <?php echo number_format($total_collection, 2); ?> TK</p>
                        <p><strong>Total Due:</strong> <?php echo number_format($total_due, 2); ?> TK</p>
                        <hr>

                        <!-- Sold and Unsold Flats -->
                        <p><strong>Sold Flats:</strong> <?php echo $sold_flats; ?></p>
                        <p><strong>Unsold Flats:</strong> <?php echo $unsold_flats; ?></p>
                        <hr>

                        <!-- Car Park Statistics -->
                        <p><strong>Total Car Parks:</strong> <?php echo $total_car_parks; ?></p>
                        <p><strong>Sold Car Parks:</strong> <?php echo $sold_car_parks; ?></p>
                        <p><strong>Unsold Car Parks:</strong> <?php echo $unsold_car_parks; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>