<?php
// Include header
if (file_exists('includes/header.php')) {
    include 'includes/header.php';
} else {
    die('Header file not found!');
}
?>

<div class="container fade-in">
    <h1 class="text-center my-4">Welcome to e-Real Estate</h1>
    <p class="text-center mb-5">A dynamic, open-source, user-friendly web-based application for real estate management.</p>

    <!-- Cards for Quick Access -->
    <div class="row">
        <!-- Dashboard Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-tachometer-alt fa-4x text-primary mb-3"></i>
                    <h5 class="card-title">Dashboard</h5>
                    <p class="card-text">View overall statistics and reports.</p>
                    <a href="<?php echo htmlspecialchars('pages/dashboard.php'); ?>" class="btn btn-primary">Go to Dashboard</a>
                </div>
            </div>
        </div>

        <!-- Projects Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-project-diagram fa-4x text-success mb-3"></i>
                    <h5 class="card-title">Projects</h5>
                    <p class="card-text">Manage and view all projects.</p>
                    <a href="<?php echo htmlspecialchars('pages/projects.php'); ?>" class="btn btn-success">Go to Projects</a>
                </div>
            </div>
        </div>

        <!-- Sell Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-hand-holding-usd fa-4x text-warning mb-3"></i>
                    <h5 class="card-title">Sell</h5>
                    <p class="card-text">Manage property sales.</p>
                    <a href="<?php echo htmlspecialchars('pages/sell.php'); ?>" class="btn btn-warning">Go to Sell</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Customers Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-users fa-4x text-info mb-3"></i>
                    <h5 class="card-title">Customers</h5>
                    <p class="card-text">Manage customer information.</p>
                    <a href="<?php echo htmlspecialchars('pages/customers.php'); ?>" class="btn btn-info">Go to Customers</a>
                </div>
            </div>
        </div>

        <!-- Payments Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-credit-card fa-4x text-danger mb-3"></i>
                    <h5 class="card-title">Payments</h5>
                    <p class="card-text">Manage client payments.</p>
                    <a href="<?php echo htmlspecialchars('pages/payments.php'); ?>" class="btn btn-danger">Go to Payments</a>
                </div>
            </div>
        </div>

        <!-- Reports Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-chart-pie fa-4x text-secondary mb-3"></i>
                    <h5 class="card-title">Reports</h5>
                    <p class="card-text">View detailed reports.</p>
                    <a href="<?php echo htmlspecialchars('pages/reports.php'); ?>" class="btn btn-secondary">Go to Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
if (file_exists('includes/footer.php')) {
    include 'includes/footer.php';
} else {
    die('Footer file not found!');
}
?>