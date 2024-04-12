<?php
session_start(); 

if (!isset($_SESSION['username']) || !isset($_SESSION['userType'])) {
    header('Location: index.html'); 
    exit();
}

$dashboardLink = 'employee_dashboard.php'; 
if ($_SESSION['userType'] === 'admin') {
    $dashboardLink = 'admin_dashboard.php'; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Successful</title>
    <link rel="stylesheet" href="success.css">
</head>
<body>
    <div class="container">
        <h2>Submission Successful!</h2>
        <p>Your bug report has been successfully submitted.</p>

        <a href="<?php echo $dashboardLink; ?>">Go Back to Dashboard</a><br>
        <a href="report_bug.html">Report Another Bug</a>
    </div>
</body>
</html>
