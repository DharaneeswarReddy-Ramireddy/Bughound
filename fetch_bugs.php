<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bug_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT report_id, program, severity, problem_summary FROM bug_reports";

$conditions = [];
$params = [];
$types = '';




if (!empty($_GET['report_id'])) {
    $conditions[] = "report_id = ?";
    $params[] = $_GET['report_id'];
    $types .= 'i';
}
if (!empty($_GET['program'])) {
    $conditions[] = "program LIKE ?";
    $params[] = '%' . $_GET['program'] . '%';
    $types .= 's';
}
if (!empty($_GET['report_type'])) {
    $conditions[] = "report_type = ?";
    $params[] = $_GET['report_type'];
    $types .= 's';
}
if (!empty($_GET['severity'])) {
    $conditions[] = "severity = ?";
    $params[] = $_GET['severity'];
    $types .= 's';
}
if (!empty($_GET['reported_by'])) {
    $conditions[] = "reported_by = ?";
    $params[] = $_GET['reported_by'];
    $types .= 's';
}
if (!empty($_GET['date'])) {
    $conditions[] = "date = ?";
    $params[] = $_GET['date'];
    $types .= 's';
}
if (!empty($_GET['functional_area'])) {
    $conditions[] = "functional_area = ?";
    $params[] = $_GET['functional_area'];
    $types .= 's';
}
if (!empty($_GET['assigned_to'])) {
    $conditions[] = "assigned_to = ?";
    $params[] = $_GET['assigned_to'];
    $types .= 's';
}
if (!empty($_GET['status'])) {
    $conditions[] = "status = ?";
    $params[] = $_GET['status'];
    $types .= 's';
}
if (!empty($_GET['priority'])) {
    $conditions[] = "priority = ?";
    $params[] = $_GET['priority'];
    $types .= 's';
}


if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}


$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

error_log(print_r($params, true));


error_log("Executing SQL query: " . $sql);
$stmt->execute();



$result = $stmt->get_result();

$bugs = [];
while ($row = $result->fetch_assoc()) {
    $bugs[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($bugs);

?>
