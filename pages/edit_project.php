<?php
// Start the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php'); // Redirect to login page if not logged in
    exit();
}

// Include the configuration file
require_once '../config.php';

// Check if the project ID is provided in the URL
if (!isset($_GET['id'])) {
    header('Location: /e-real-estate/pages/projects.php'); // Redirect if no ID is provided
    exit();
}

$project_id = intval($_GET['id']);

// Fetch the project details from the database
try {
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = :id");
    $stmt->bindParam(':id', $project_id, PDO::PARAM_INT);
    $stmt->execute();
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$project) {
        header('Location: /e-real-estate/pages/projects.php'); // Redirect if project not found
        exit();
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Include the header
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project - eRealEstate</title>
    <link rel="stylesheet" href="/e-real-estate/assets/css/styles.css">
</head>
<body>
    <div class="admin-container">
        <h1>Edit Project</h1>
        <div class="admin-menu">
            <?php include '../includes/admin_sidebar.php'; ?> <!-- Include admin sidebar -->
        </div>
        <div class="admin-content">
            <h2>Edit Project Form</h2>
            <form action="process_edit_project.php" method="POST">
                <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project['id']); ?>">
                <div class="form-group">
                    <label for="project_name">Project Name:</label>
                    <input type="text" id="project_name" name="project_name" value="<?php echo htmlspecialchars($project['project_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="project_description">Description:</label>
                    <textarea id="project_description" name="project_description" required><?php echo htmlspecialchars($project['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="project_location">Location:</label>
                    <input type="text" id="project_location" name="project_location" value="<?php echo htmlspecialchars($project['location']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="project_price">Price:</label>
                    <input type="number" id="project_price" name="project_price" value="<?php echo htmlspecialchars($project['price']); ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit">Update Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include the footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>