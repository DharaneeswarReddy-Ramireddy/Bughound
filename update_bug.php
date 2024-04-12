<?php

$db_host = 'localhost';
$db_user = 'root'; 
$db_pass = ''; 
$db_name = 'bug_db'; 


$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $program = $_POST['program'];
    $reportType = $_POST['reportType'];
    $severity = $_POST['severity'];
    $problemSummary = $_POST['problemSummary'];
    $reproducible = isset($_POST['reproducible']) ? 1 : 0;
    $suggestedFix = $_POST['suggestedFix'];
    $reportedBy = $_POST['reportedBy'];
    $date = $_POST['date']; // reported date, required
    $functionalArea = $_POST['functionalArea'];
    $assignedTo = $_POST['assignedTo'];
    $comments = $_POST['comments'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    $resolution = $_POST['resolution'];
    $resolutionVersion = $_POST['resolutionVersion'];
    $resolvedBy = $_POST['resolvedBy'];
    
    $resolvedDate = empty($_POST['resolvedDate']) ? NULL : $_POST['resolvedDate'];
    $testedBy = $_POST['testedBy'];
    $testedDate = empty($_POST['testedDate']) ? NULL : $_POST['testedDate'];
    $deferred = isset($_POST['deferred']) ? 1 : 0;

    $report_id = $_POST['report_id'];
  
    // Update query
    $stmt = $mysqli->prepare("UPDATE bug_reports SET 
              program = ?, 
              report_type = ?, 
              severity = ?, 
              problem_summary = ?, 
              reproducible = ?, 
              suggested_fix = ?, 
              reported_by = ?, 
              date = ?, 
              functional_area = ?, 
              assigned_to = ?, 
              comments = ?, 
              status = ?, 
              priority = ?, 
              resolution = ?, 
              resolution_version = ?, 
              resolved_by = ?, 
              resolved_date = ?, 
              tested_by = ?, 
              tested_date = ?, 
              deferred = ? 
              WHERE report_id = ?");

    $stmt->bind_param("ssssissssssssssssssii", 
    $program, $reportType, $severity, $problemSummary, $reproducible, $suggestedFix, 
    $reportedBy, $date, $functionalArea, $assignedTo, $comments, $status, $priority, 
    $resolution, $resolutionVersion, $resolvedBy, $resolvedDate, $testedBy, $testedDate, 
    $deferred,$report_id);

    if ($stmt->execute()) {
        header("Location: success.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "No data submitted.";
}
?>
