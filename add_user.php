<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli('localhost', 'root', '', 'bug_tracker');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $userType = $_POST['userType'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, userType) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $userType);
    
    if ($stmt->execute()) {
        echo "New user added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    header("Location: admin_dashboard.php"); // Redirect back to admin dashboard
    exit();
}
?>
