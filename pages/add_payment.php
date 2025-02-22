<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

include '../includes/header.php';
include '../config.php';

// Fetch all customers for dropdown
$customers = $conn->query("SELECT id, customer_name FROM customers")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = intval($_POST['customer_id']);
    $mr_no = htmlspecialchars($_POST['mr_no']);
    $payment_amount = floatval($_POST['payment_amount']);
    $due_amount = floatval($_POST['due_amount']);
    $payment_date = htmlspecialchars($_POST['payment_date']);

    // Validate form data
    if (empty($customer_id) || empty($mr_no) || empty($payment_amount) || empty($payment_date)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        // Insert data into the database
        try {
            $stmt = $conn->prepare("INSERT INTO payments (customer_id, mr_no, payment_amount, due_amount, payment_date) VALUES (:customer_id, :mr_no, :payment_amount, :due_amount, :payment_date)");
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->bindParam(':mr_no', $mr_no);
            $stmt->bindParam(':payment_amount', $payment_amount);
            $stmt->bindParam(':due_amount', $due_amount);
            $stmt->bindParam(':payment_date', $payment_date);
            $stmt->execute();

            echo "<div class='alert alert-success'>Payment added successfully!</div>";
            // Reset form fields (optional)
            echo "<script>document.getElementById('paymentForm').reset();</script>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<div class="container fade-in">
    <h1 class="text-center my-4">Add New Payment</h1>
    <form id="paymentForm" action="add_payment.php" method="POST">
        <div class="form-group">
            <label for="customer_id">Customer:</label>
            <select class="form-control" id="customer_id" name="customer_id" required>
                <option value="">Select Customer</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?php echo htmlspecialchars($customer['id']); ?>"><?php echo htmlspecialchars($customer['customer_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="mr_no">MR No:</label>
            <input type="text" class="form-control" id="mr_no" name="mr_no" required>
        </div>
        <div class="form-group">
            <label for="payment_amount">Payment Amount:</label>
            <input type="number" step="0.01" class="form-control" id="payment_amount" name="payment_amount" required>
        </div>
        <div class="form-group">
            <label for="due_amount">Due Amount:</label>
            <input type="number" step="0.01" class="form-control" id="due_amount" name="due_amount" required>
        </div>
        <div class="form-group">
            <label for="payment_date">Payment Date:</label>
            <input type="date" class="form-control" id="payment_date" name="payment_date" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Payment</button>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>