<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /e-real-estate/pages/login.php');
    exit();
}

include '../config.php';

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID

    // Fetch customer details
    $stmt = $conn->prepare("SELECT * FROM customers WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer) {
        $_SESSION['error_message'] = "Error: Customer not found.";
        header("Location: /e-real-estate/pages/customers.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Error: No customer ID provided.";
    header("Location: /e-real-estate/pages/customers.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = htmlspecialchars($_POST['customer_name']);
    $father_name = htmlspecialchars($_POST['father_name']);
    $date_of_birth = htmlspecialchars($_POST['date_of_birth']);
    $occupation = htmlspecialchars($_POST['occupation']);
    $present_address = htmlspecialchars($_POST['present_address']);
    $permanent_address = htmlspecialchars($_POST['permanent_address']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $nationality = htmlspecialchars($_POST['nationality']);
    $nid_passport = htmlspecialchars($_POST['nid_passport']);
    $tin_number = htmlspecialchars($_POST['tin_number']);
    $car_parking = htmlspecialchars($_POST['car_parking']);
    $loan_option = htmlspecialchars($_POST['loan_option']);
    $payment_mode = htmlspecialchars($_POST['payment_mode']);

    // Update customer details
    $stmt = $conn->prepare("
        UPDATE customers SET
        customer_name = :customer_name,
        father_name = :father_name,
        date_of_birth = :date_of_birth,
        occupation = :occupation,
        present_address = :present_address,
        permanent_address = :permanent_address,
        phone_number = :phone_number,
        nationality = :nationality,
        nid_passport = :nid_passport,
        tin_number = :tin_number,
        car_parking = :car_parking,
        loan_option = :loan_option,
        payment_mode = :payment_mode
        WHERE id = :id
    ");
    $stmt->bindParam(':customer_name', $customer_name);
    $stmt->bindParam(':father_name', $father_name);
    $stmt->bindParam(':date_of_birth', $date_of_birth);
    $stmt->bindParam(':occupation', $occupation);
    $stmt->bindParam(':present_address', $present_address);
    $stmt->bindParam(':permanent_address', $permanent_address);
    $stmt->bindParam(':phone_number', $phone_number);
    $stmt->bindParam(':nationality', $nationality);
    $stmt->bindParam(':nid_passport', $nid_passport);
    $stmt->bindParam(':tin_number', $tin_number);
    $stmt->bindParam(':car_parking', $car_parking);
    $stmt->bindParam(':loan_option', $loan_option);
    $stmt->bindParam(':payment_mode', $payment_mode);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Customer updated successfully!";
        header("Location: /e-real-estate/pages/customers.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error: Unable to update customer.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container fade-in">
    <h1 class="text-center my-4">Edit Customer</h1>

    <!-- Display success/error messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?></div>
    <?php endif; ?>

    <!-- Edit Customer Form -->
    <form method="POST" action="edit_customer.php?id=<?php echo $id; ?>">
        <div class="form-group">
            <label for="customer_name">Customer Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($customer['customer_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="father_name">Father/Husband Name</label>
            <input type="text" class="form-control" id="father_name" name="father_name" value="<?php echo htmlspecialchars($customer['father_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($customer['date_of_birth']); ?>" required>
        </div>
        <div class="form-group">
            <label for="occupation">Occupation</label>
            <input type="text" class="form-control" id="occupation" name="occupation" value="<?php echo htmlspecialchars($customer['occupation']); ?>" required>
        </div>
        <div class="form-group">
            <label for="present_address">Present Address</label>
            <textarea class="form-control" id="present_address" name="present_address" required><?php echo htmlspecialchars($customer['present_address']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="permanent_address">Permanent Address</label>
            <textarea class="form-control" id="permanent_address" name="permanent_address" required><?php echo htmlspecialchars($customer['permanent_address']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($customer['phone_number']); ?>" required>
        </div>
        <div class="form-group">
            <label for="nationality">Nationality</label>
            <input type="text" class="form-control" id="nationality" name="nationality" value="<?php echo htmlspecialchars($customer['nationality']); ?>" required>
        </div>
        <div class="form-group">
            <label for="nid_passport">NID/Passport Number</label>
            <input type="text" class="form-control" id="nid_passport" name="nid_passport" value="<?php echo htmlspecialchars($customer['nid_passport']); ?>" required>
        </div>
        <div class="form-group">
            <label for="tin_number">TIN Number</label>
            <input type="text" class="form-control" id="tin_number" name="tin_number" value="<?php echo htmlspecialchars($customer['tin_number']); ?>" required>
        </div>
        <div class="form-group">
            <label for="car_parking">Car Parking</label>
            <select class="form-control" id="car_parking" name="car_parking" required>
                <option value="yes" <?php echo $customer['car_parking'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?php echo $customer['car_parking'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>
        </div>
        <div class="form-group">
            <label for="loan_option">Loan Option</label>
            <select class="form-control" id="loan_option" name="loan_option" required>
                <option value="yes" <?php echo $customer['loan_option'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?php echo $customer['loan_option'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>
        </div>
        <div class="form-group">
            <label for="payment_mode">Payment Mode</label>
            <select class="form-control" id="payment_mode" name="payment_mode" required>
                <option value="one_time" <?php echo $customer['payment_mode'] == 'one_time' ? 'selected' : ''; ?>>One Time</option>
                <option value="installments" <?php echo $customer['payment_mode'] == 'installments' ? 'selected' : ''; ?>>Installments</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Customer</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>