<?php
session_start();
if ($_SESSION['userType'] != 'admin') {
    header("Location: login.html"); // Redirect non-admins back to login page
    exit();
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $conn = new mysqli('localhost', 'root', '', 'bug_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    
    if ($stmt->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}

header("Location: admin_dashboard.php"); // Redirect back to admin dashboard
exit();
?>
