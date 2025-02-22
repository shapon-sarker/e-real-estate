<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ফর্ম ডেটা সংগ্রহ করুন
    $flat_no = htmlspecialchars($_POST['flat_no']);
    $project_id = intval($_POST['project_id']);

    // ভ্যালিডেশন
    if (empty($flat_no) || empty($project_id)) {
        $_SESSION['error_message'] = "All fields are required.";
        header("Location: /e-real-estate/pages/add_sell.php");
        exit();
    }

    // ডাটাবেসে ডেটা ইনসার্ট করুন
    $stmt = $conn->prepare("INSERT INTO flats (flat_no, project_id) VALUES (:flat_no, :project_id)");
    $stmt->bindParam(':flat_no', $flat_no);
    $stmt->bindParam(':project_id', $project_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Sell added successfully!";
        header("Location: /e-real-estate/pages/sell.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error: Unable to add sell.";
        header("Location: /e-real-estate/pages/add_sell.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: /e-real-estate/pages/add_sell.php");
    exit();
}
?>