<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

include '../includes/header.php';
include '../config.php';

// Fetch all projects and flats for dropdowns
$projects = $conn->query("SELECT id, project_name FROM projects")->fetchAll(PDO::FETCH_ASSOC);
$flats = $conn->query("SELECT id, flat_no FROM flats")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = htmlspecialchars($_POST['customer_name']);
    $project_id = intval($_POST['project_id']);
    $flat_id = intval($_POST['flat_id']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);

    // Validate form data
    if (empty($customer_name) || empty($project_id) || empty($flat_id)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        // Insert data into the database
        try {
            $stmt = $conn->prepare("INSERT INTO customers (customer_name, project_id, flat_id, phone, email) VALUES (:customer_name, :project_id, :flat_id, :phone, :email)");
            $stmt->bindParam(':customer_name', $customer_name);
            $stmt->bindParam(':project_id', $project_id);
            $stmt->bindParam(':flat_id', $flat_id);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            echo "<div class='alert alert-success'>Customer added successfully!</div>";
            // Reset form fields (optional)
            echo "<script>document.getElementById('customerForm').reset();</script>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<div class="container fade-in">
    <h1 class="text-center my-4">Add New Customer</h1>
    <form id="customerForm" action="add_customer.php" method="POST">
        <div class="form-group">
            <label for="customer_name">Customer Name:</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="form-group">
            <label for="project_id">Project:</label>
            <select class="form-control" id="project_id" name="project_id" required>
                <option value="">Select Project</option>
                <?php foreach ($projects as $project): ?>
                    <option value="<?php echo htmlspecialchars($project['id']); ?>"><?php echo htmlspecialchars($project['project_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="flat_id">Flat No:</label>
            <select class="form-control" id="flat_id" name="flat_id" required>
                <option value="">Select Flat</option>
                <?php foreach ($flats as $flat): ?>
                    <option value="<?php echo htmlspecialchars($flat['id']); ?>"><?php echo htmlspecialchars($flat['flat_no']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Customer</button>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>