<?php
require_once 'config.php';

try {
    $stmt = $conn->query("SELECT 1");
    echo "Database connection is working!";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>