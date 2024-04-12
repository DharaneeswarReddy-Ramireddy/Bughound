<?php
session_start();
if ($_SESSION['userType'] != 'admin') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
    <link rel="stylesheet" href="user_mgmt.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>

        <div class="user-form">
            <h2>Add User</h2>
            <form action="add_user.php" method="post">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <select name="userType" required>
                    <option value="admin">Admin</option>
                    <option value="employee">Employee</option>
                </select><br>
                <input type="submit" value="Add User">
            </form>
        </div>

        <div class="user-list">
            <h2>Existing Users</h2>
            <?php
            $conn = new mysqli('localhost', 'root', '', 'bug_db');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id, username, userType FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<ul>";
                while($row = $result->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($row["username"]) . " (" . htmlspecialchars($row["userType"]) . ") <a href='delete_user.php?id=" . htmlspecialchars($row["id"]) . "'>Delete</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No users found.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
