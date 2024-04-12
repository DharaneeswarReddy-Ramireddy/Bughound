<?php
session_start();
if ($_SESSION['userType'] != 'admin') {
    header("Location: login.html"); // Redirect non-admins
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Bug</title>
    <link rel="stylesheet" href="bug_list_style.css"> <!-- Path to your CSS file -->
</head>
<body>
    <h1>Delete Bugs</h1>

    <?php
    $conn = new mysqli('localhost', 'root', '', 'bug_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT report_id, program, report_type, severity FROM bug_reports";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<ul id='bugList'>";
        while($row = $result->fetch_assoc()) {
            echo "<li id='bug_" . $row["report_id"] . "'>";
            echo "<div>Report ID: " . htmlspecialchars($row["report_id"]) . "</div>";
            echo "<div>Program: " . htmlspecialchars($row["program"]) . "</div>";
            echo "<div>Type: " . htmlspecialchars($row["report_type"]) . "</div>";
            echo "<div>Severity: " . htmlspecialchars($row["severity"]) . "</div>";
            echo "<button onclick='deleteBug(" . $row["report_id"] . ")'>Delete</button>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "No bugs found.";
    }
    $conn->close();
    ?>

    <script src="bug_list_script.js"></script> <!-- Path to your JavaScript file -->
</body>
</html>
