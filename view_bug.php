<?php
// Database connection settings
$db_host = 'localhost';
$db_user = 'root'; // replace with your database username
$db_pass = ''; // replace with your database password
$db_name = 'bug_db'; // replace with your database name

// Connect to the database
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Function to get bug details by report_id
function getBugDetails($report_id, $mysqli) {
    $stmt = $mysqli->prepare("SELECT * FROM bug_reports WHERE report_id = ?");
    if(!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        exit('No such bug found!');
    }
    return $result->fetch_assoc();
}

// Check if report_id is provided
if (!isset($_GET['report_id'])) {
    die('Error: No report ID provided.');
}

$report_id = $_GET['report_id'];
$bug = getBugDetails($report_id, $mysqli);

// Close the database connection
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bug Report</title>
    <link rel="stylesheet" href="report.css">
</head>
<body>
    <div class="container">
        <h2>Edit Bug Report #<?php echo htmlspecialchars($bug['report_id']); ?></h2>
        <form action="update_bug.php" method="POST">
            <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($bug['report_id']); ?>">

            <label for="program">Program:</label>
            <input type="text" id="program" name="program" value="<?php echo htmlspecialchars($bug['program']); ?>" required><br>

            <label for="reportType">Report Type:</label>
            <select id="reportType" name="reportType">
                <option value="coding error">Coding Error</option>
                    <option value="Design Issue">Design Issue</option>
                    <option value="Suggestion">Suggestion</option>
                    <option value="Documentation">Documentation</option>
                    <option value="Hardware">Hardware</option>
                    <option value="Query">Query</option>
            </select><br>

            <label for="severity">Severity:</label>
            <select id="severity" name="severity">
                <option value="minor">Minor</option>
                    <option value="minor">Major</option>
                    <option value="minor">Critical</option>
            </select><br>

            <label for="problemSummary">Problem Summary:</label>
            <textarea id="problemSummary" name="problemSummary" required><?php echo htmlspecialchars($bug['problem_summary']); ?></textarea><br>

            <label for="reproducible">Reproducible?</label>
            <input type="checkbox" id="reproducible" name="reproducible" value="yes" <?php echo ($bug['reproducible'] == 1) ? 'checked' : ''; ?>><br>

            <label for="suggestedFix">Suggested Fix:</label>
            <textarea id="suggestedFix" name="suggestedFix"><?php echo htmlspecialchars($bug['suggested_fix']); ?></textarea><br>

            <label for="reportedBy">Reported By:</label>
            <input type="text" id="reportedBy" name="reportedBy" value="<?php echo htmlspecialchars($bug['reported_by']); ?>" required><br>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($bug['date']); ?>" required><br>

            <label for="functionalArea">Functional Area:</label>
            <input type="text" id="functionalArea" name="functionalArea" value="<?php echo htmlspecialchars($bug['functional_area']); ?>"><br>

            <label for="assignedTo">Assigned To:</label>
            <input type="text" id="assignedTo" name="assignedTo" value="<?php echo htmlspecialchars($bug['assigned_to']); ?>"><br>

            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments"><?php echo htmlspecialchars($bug['comments']); ?></textarea><br>

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="Open">Open</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Resolved">Resolved</option>
            </select><br>

            <label for="priority">Priority:</label>
            <select id="priority" name="priority">
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select><br>

            <label for="resolution">Resolution:</label>
            <input type="text" id="resolution" name="resolution" value="<?php echo htmlspecialchars($bug['resolution']); ?>"><br>

            <label for="resolutionVersion">Resolution Version:</label>
            <input type="text" id="resolutionVersion" name="resolutionVersion" value="<?php echo htmlspecialchars($bug['resolution_version']); ?>"><br>

            <label for="resolvedBy">Resolved By:</label>
            <input type="text" id="resolvedBy" name="resolvedBy" value="<?php echo htmlspecialchars($bug['resolved_by']); ?>"><br>

            <label for="resolvedDate">Resolved Date:</label>
            <input type="date" id="resolvedDate" name="resolvedDate" value="<?php echo htmlspecialchars($bug['resolved_date']); ?>"><br>

            <label for="testedBy">Tested By:</label>
            <input type="text" id="testedBy" name="testedBy" value="<?php echo htmlspecialchars($bug['tested_by']); ?>"><br>

            <label for="testedDate">Tested Date:</label>
            <input type="date" id="testedDate" name="testedDate" value="<?php echo htmlspecialchars($bug['tested_date']); ?>"><br>

            <label for="deferred">Treat as deferred?</label>
            <input type="checkbox" id="deferred" name="deferred" value="yes" <?php echo ($bug['deferred'] == 1) ? 'checked' : ''; ?>><br>

            <button type="submit">Update Bug</button>
        </form>
    </div>
</body>
</html>