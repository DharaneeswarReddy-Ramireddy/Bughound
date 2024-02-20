<?php
session_start();
if ($_SESSION['userType'] != 'employee') {
    header("Location: login.html"); // Redirect non-employees back to login page
    exit();
}

echo "<h1>Employee Dashboard</h1>";
echo "<a href='add_bug.html'>Add Bug</a> | <a href='view_bugs.php'>View Bugs</a> | <a href='modify_bug.php'>Modify Bug</a>";
?>
