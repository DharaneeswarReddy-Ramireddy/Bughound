<?php
session_start();
if ($_SESSION['userType'] != 'admin') {
    echo 'Unauthorized access.';
    exit();
}

$reportId = $_POST['report_id'];

$conn = new mysqli('localhost', 'root', '', 'bug_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("DELETE FROM bug_reports WHERE report_id = ?");
$stmt->bind_param("i", $reportId);

if ($stmt->execute()) {
    echo "Bug deleted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
