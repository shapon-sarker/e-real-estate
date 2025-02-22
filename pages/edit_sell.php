<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

// Include the configuration file
require_once '../config.php';

// Check if the sell ID is provided in the URL
if (!isset($_GET['id'])) {
    header('Location: /e-real-estate/pages/sell.php'); // Redirect if no ID is provided
    exit();
}

$sell_id = intval($_GET['id']);

// Fetch the sell details from the database
try {
    $stmt = $conn->prepare("SELECT flats.*, projects.project_name FROM flats JOIN projects ON flats.project_id = projects.id WHERE flats.id = :id");
    $stmt->bindParam(':id', $sell_id, PDO::PARAM_INT);
    $stmt->execute();
    $sell = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$sell) {
        header('Location: /e-real-estate/pages/sell.php'); // Redirect if sell not found
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
    <title>Edit Sell - eRealEstate</title>
    <link rel="stylesheet" href="/e-real-estate/assets/css/styles.css">
</head>
<body>
    <div class="container fade-in">
        <h1 class="text-center my-4">Edit Sell</h1>
        <form action="process_edit_sell.php" method="POST">
            <input type="hidden" name="sell_id" value="<?php echo htmlspecialchars($sell['id']); ?>">
            <div class="form-group">
                <label for="flat_no">Flat No:</label>
                <input type="text" id="flat_no" name="flat_no" value="<?php echo htmlspecialchars($sell['flat_no']); ?>" required>
            </div>
            <div class="form-group">
                <label for="project_id">Project:</label>
                <select class="form-control" id="project_id" name="project_id" required>
                    <?php
                    $stmt = $conn->query("SELECT id, project_name FROM projects");
                    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($projects as $project) {
                        $selected = ($project['id'] == $sell['project_id']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($project['id']) . "' $selected>" . htmlspecialchars($project['project_name']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Sell</button>
            </div>
        </form>
    </div>

    <!-- Include the footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>