<?php
session_start();

$host = 'localhost';
$dbname = 'bug_tracker';
$dbUsername = 'root';
$dbPassword = '';

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $inputPassword = $_POST['password']; // The password entered by the user
    $userType = $_POST['userType'];

    // Adjust the SQL to fetch the password for verification
    $sql = "SELECT id, password FROM users WHERE username = ? AND userType = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $userType);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Now verify the password against the hashed password in the database
        if (password_verify($inputPassword, $row['password'])) {
            // Password is correct
            $_SESSION['username'] = $username;
            $_SESSION['userType'] = $userType;

            if ($userType == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: employee_dashboard.php");
            }
            exit;
        } else {
            // Password didn't match
            echo "Invalid username or password.";
        }
    } else {
        // No user found
        echo "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
