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
?>

<div class="container fade-in">
    <h1 class="text-center my-4">Projects</h1>
    <a href="/e-real-estate/pages/add_project.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Add New Project</a>

    <!-- All Project List -->
    <?php if (empty($projects)): ?>
        <div class="alert alert-info">No projects found.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($projects as $project): ?>
            <?php
            $project_id = $project['id'];
            $total_flats = $project['total_flats'];
            $sold_flats = $project['sold_flats'];
            $unsold_flats = $total_flats - $sold_flats;
            ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($project['project_name']); ?></h5>
                        <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($project['location']); ?></p>
                        <hr>

                        <!-- Project Wise Flat List -->
                        <p><strong>Total Flats:</strong> <?php echo $total_flats; ?></p>
                        <p><strong>Sold Flats:</strong> <?php echo $sold_flats; ?></p>
                        <p><strong>Unsold Flats:</strong> <?php echo $unsold_flats; ?></p>
                        <hr>

                        <!-- Flat List -->
                        <h6>Flat List:</h6>
                        <ul>
                            <?php if (empty($flats)): ?>
                                <li>No flats found.</li>
                            <?php else: ?>
                                <?php foreach ($flats as $flat): ?>
                                <?php if ($flat['project_id'] == $project_id): ?>
                                <li>
                                    Flat No: <?php echo htmlspecialchars($flat['flat_no']); ?> |
                                    Size: <?php echo htmlspecialchars($flat['flat_size_sft']); ?> sft |
                                    Status: <?php echo htmlspecialchars($flat['status']); ?>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                        <hr>

                        <!-- Action Buttons -->
                        <div class="text-center">
                            <a href="edit_project.php?id=<?php echo htmlspecialchars($project['id']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <a href="delete_project.php?id=<?php echo htmlspecialchars($project['id']); ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>