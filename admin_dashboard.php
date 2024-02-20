<?php
session_start();
if ($_SESSION['userType'] != 'admin') {
    header("Location: login.html"); // Redirect non-admins back to login page
    exit();
}

echo "<h1>Admin Dashboard</h1>";

// Form for adding a new user
echo "<h2>Add User</h2>";
echo "<form action='add_user.php' method='post'>
        Username: <input type='text' name='username' required><br>
        Password: <input type='password' name='password' required><br>
        User Type: <select name='userType' required>
            <option value='admin'>Admin</option>
            <option value='employee'>Employee</option>
        </select><br>
        <input type='submit' value='Add User'>
      </form>";

// Listing users with a delete option
echo "<h2>Existing Users</h2>";

$conn = new mysqli('localhost', 'root', '', 'bug_tracker');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, username, userType FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>" . $row["username"] . " (" . $row["userType"] . ") <a href='delete_user.php?id=" . $row["id"] . "'>Delete</a></p>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
