<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.html');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="employee_dashboard.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <nav>
            <ul>
                <li><a href="report_bug.html">Report New Bug</a></li>
                <li><a href="logout.html">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>

    <form id="searchForm">
            <input type="text" name="report_id" placeholder="Report ID"><br>
            <input type="text" name="program" placeholder="Program"><br>
            
            <select name="report_type">
            <option value="" selected>Select Report Type</option>
                <option value="coding error">Coding Error</option>
                <option value="Design Issue">Design Issue</option>
                <option value="Suggestion">Suggestion</option>
                <option value="Documentation">Documentation</option>
                <option value="Hardware">Hardware</option>
                <option value="Query">Query</option>
            </select><br>
            
            <select name="severity">
                <option value="" selected>Select Severity</option>
                <option value="minor">Minor</option>
                <option value="minor">Major</option>
                <option value="minor">Critical</option>
            </select><br>

            <select name="status">
                <option value="" selected>Select Status</option>
                <option value="Open">Open</option>
                <option value="In Progress">In Progress</option>
                <option value="Resolved">Resolved</option>
            </select><br>

            <select name="priority">
                <option value="" selected>Select Priority</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select><br>

            <input type="text" name="reported_by" placeholder="Reported By"><br>
            <label for="date">Reported on Date: </label>
            <input type="date" id="date" name="date"><br>
            <input type="text" name="functional_area" placeholder="Functional Area"><br>
            <input type="text" name="assigned_to" placeholder="Assigned To"><br>
            
            <button type="submit">Search</button>
        </form>


        <section id="bugSection">
            <h2>Bugs</h2>
            <ul id="bugList">
                <!-- Bug items will be dynamically added here -->
            </ul>
        </section>
    </main>

    <footer>
        <p>Employee Dashboard Footer</p>
    </footer>

    <script src="emp_dash_script.js"></script>
    
</body>
</html>
