<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://localhost/e-real-estate/">
    <title>e-Real Estate</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <?php if (file_exists('assets/css/styles.css')): ?>
        <link rel="stylesheet" href="assets/css/styles.css">
    <?php else: ?>
        <style>
            /* Fallback styles if the custom CSS file is missing */
            body { font-family: Arial, sans-serif; }
        </style>
    <?php endif; ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">e-Real Estate</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="<?php echo htmlspecialchars('index.php'); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="<?php echo htmlspecialchars('pages/dashboard.php'); ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'projects.php' ? 'active' : ''; ?>" href="<?php echo htmlspecialchars('pages/projects.php'); ?>">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'sell.php' ? 'active' : ''; ?>" href="<?php echo htmlspecialchars('pages/sell.php'); ?>">Sell</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'customers.php' ? 'active' : ''; ?>" href="<?php echo htmlspecialchars('pages/customers.php'); ?>">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'payments.php' ? 'active' : ''; ?>" href="<?php echo htmlspecialchars('pages/payments.php'); ?>">Payments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : ''; ?>" href="<?php echo htmlspecialchars('pages/reports.php'); ?>">Reports</a>
                </li>

                </li>
                    <!-- Admin Login/Logout Link -->
                    <li class="nav-item">
                        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                            <a class="nav-link btn btn-outline-light" href="admin/logout.php">Logout</a>
                        <?php else: ?>
                            <a class="nav-link btn btn-outline-light" href="admin/admin.php">Admin Login</a>
                        <?php endif; ?>
                    </li>
            </ul>
        </div>
    </div>
</nav>