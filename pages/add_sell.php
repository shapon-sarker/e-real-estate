<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

include '../includes/header.php';

// ফর্ম সাবমিশন হ্যান্ডলিং
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config.php';

    // ফর্ম ডেটা সংগ্রহ করুন
    $flat_no = htmlspecialchars($_POST['flat_no']);
    $project_id = intval($_POST['project_id']);

    // ভ্যালিডেশন
    if (empty($flat_no) || empty($project_id)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        // ডাটাবেসে ডেটা ইনসার্ট করুন
        try {
            $stmt = $conn->prepare("INSERT INTO flats (flat_no, project_id, status) VALUES (:flat_no, :project_id, 'sold')");
            $stmt->bindParam(':flat_no', $flat_no);
            $stmt->bindParam(':project_id', $project_id);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Sell added successfully!</div>";
                // ফর্ম ফিল্ড রিসেট করুন (ঐচ্ছিক)
                echo "<script>document.getElementById('sellForm').reset();</script>";
            } else {
                echo "<div class='alert alert-danger'>Error: Unable to add sell.</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<div class="container fade-in">
    <h1 class="text-center my-4">Add New Sell</h1>
    <form id="sellForm" action="add_sell.php" method="POST">
        <div class="form-group">
            <label for="flat_no">Flat No</label>
            <input type="text" class="form-control" id="flat_no" name="flat_no" required>
        </div>
        <div class="form-group">
            <label for="project_id">Project</label>
            <select class="form-control" id="project_id" name="project_id" required>
                <?php
                include '../config.php';
                $stmt = $conn->query("SELECT id, project_name FROM projects");
                $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($projects as $project) {
                    echo "<option value='" . htmlspecialchars($project['id']) . "'>" . htmlspecialchars($project['project_name']) . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Sell</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>