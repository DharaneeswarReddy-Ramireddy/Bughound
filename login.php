<?php

session_start();


$host = 'localhost';
$dbname = 'bug_db'; 
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']); // Hash the password using SHA-256
    $userType = $_POST['userType'];

        $sql = "SELECT * FROM users WHERE username = ? AND userType = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $userType]);
    $user = $stmt->fetch();

        if ($user) {
        if ($password === $user['password']) { 
            
            $_SESSION['username'] = $username;
            $_SESSION['userType'] = $userType;
            
            // Redirect to dashboard based on user type
            if ($userType === 'admin') {
                header('Location: admin_dashboard.php');
                exit();
            } elseif ($userType === 'employee') {
                header('Location: employee_dashboard.php');
                exit();
            }
        } else {
            
            echo 'Invalid password. Please try again.';
        }
    } else {
        
        echo 'User not found. Please try again.';
    }
} else {
    
    header('Location: index.html');
    exit();
}
?>
