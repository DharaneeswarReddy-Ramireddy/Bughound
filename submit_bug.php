<?php
session_start();

if ($_SESSION['userType'] != 'employee') {
    header("Location: login.html"); // Redirect non-employees back to login page
    exit();
}

$host = 'localhost';
$dbname = 'bug_tracker';
$dbUsername = 'root';
$dbPassword = '';

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $program = $_POST['program'];
    $summary = $_POST['summary'];
    $problem = $_POST['problem'];
    // The rest of the fields are optional, so we check if they're set and assign null if not
    $reportType = $_POST['reportType'] ?? null;
    $severity = $_POST['severity'] ?? null;
    $reproducible = isset($_POST['reproducible']) ? 1 : 0; // Checkbox for reproducible
    $suggestedFix = $_POST['suggestedFix'] ?? null;
    $reportedBy = $_POST['reportedBy'] ?? null;
    $date = $_POST['date'] ?? null;
    $functionalArea = $_POST['functionalArea'] ?? null;
    $assignedTo = $_POST['assignedTo'] ?? null;
    $comments = $_POST['comments'] ?? null;
    $status = $_POST['status'] ?? null;
    $priority = $_POST['priority'] ?? null;
    $resolution = $_POST['resolution'] ?? null;
    $resolutionVersion = $_POST['resolutionVersion'] ?? null;
    $resolvedBy = $_POST['resolvedBy'] ?? null;
    $resolvedDate = $_POST['resolvedDate'] ?? null;
    $testedBy = $_POST['testedBy'] ?? null;
    $testedDate = $_POST['testedDate'] ?? null;
    $treatAsDeferred = isset($_POST['treatAsDeferred']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO bugs (program, report_type, severity, problem_summary, reproducible, problem, suggested_fix, reported_by, report_date, functional_area, assigned_to, comments, status, priority, resolution, resolution_version, resolved_by, resolved_date, tested_by, tested_date, treat_as_deferred) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssissssssssssssssi", $program, $reportType, $severity, $summary, $reproducible, $problem, $suggestedFix, $reportedBy, $date, $functionalArea, $assignedTo, $comments, $status, $priority, $resolution, $resolutionVersion, $resolvedBy, $resolvedDate, $testedBy, $testedDate, $treatAsDeferred);

    if ($stmt->execute()) {
        echo "New bug reported successfully.";
        header("Location: employee_dashboard.php"); // Redirect back to the dashboard
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No data submitted.";
}
?>
