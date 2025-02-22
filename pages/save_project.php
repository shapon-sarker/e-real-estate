<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ফর্ম ডেটা সংগ্রহ করুন
    $project_name = htmlspecialchars($_POST['project_name']);
    $location = htmlspecialchars($_POST['location']);

    // ভ্যালিডেশন
    if (empty($project_name) || empty($location)) {
        $_SESSION['error_message'] = "All fields are required.";
        header("Location: /e-real-estate/pages/add_project.php");
        exit();
    }

    // ডাটাবেসে ডেটা ইনসার্ট করুন
    $stmt = $conn->prepare("INSERT INTO projects (project_name, location) VALUES (:project_name, :location)");
    $stmt->bindParam(':project_name', $project_name);
    $stmt->bindParam(':location', $location);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Project added successfully!";
        header("Location: /e-real-estate/pages/projects.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error: Unable to add project.";
        header("Location: /e-real-estate/pages/add_project.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: /e-real-estate/pages/add_project.php");
    exit();
}
?>