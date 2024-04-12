# Bug Tracking System

## System Requirements:
- **WAMP Server**: Ensure you have WAMP installed and running.
- **Web Browser**: Google Chrome, Mozilla Firefox, etc.
- **Code Editor**: Visual Studio Code, Sublime Text, etc.

## Installation Steps:
### 1. Install WAMP Server
Download and install WAMP Server from [WAMP Server Official Site](http://www.wampserver.com/en/).
- Follow the installation instructions.
- Start WAMP Server and ensure the tray icon is green.

### 2. Setup Database
- Open your web browser and navigate to [phpMyAdmin](http://localhost/phpmyadmin).
- Login with your MySQL credentials (default is `username: 'root'` with no password).
- Create a new database named `bug_db`.
- Import or execute the provided SQL commands to set up your database schema.

### 3. Configure Project
- Place your project files in the `www` directory located typically at `C:\wamp64\www\`.
- Adjust the database connection settings in your PHP scripts to match your environment.

### 4. Access the Project
- Open your web browser and go to `http://localhost/your_project_folder/` to start using the application.

## SQL Code Setup

```sql
-- Creating the 'users' table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    userType ENUM('admin', 'employee') NOT NULL
);

-- Creating the 'bug_reports' table
CREATE TABLE bug_reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    program VARCHAR(100) NOT NULL,
    report_type ENUM('Coding Error', 'Design Issue', 'Suggestion', 'Documentation', 'Hardware', 'Query') NOT NULL,
    severity ENUM('Minor', 'Major', 'Critical') NOT NULL,
    problem_summary TEXT NOT NULL,
    reproducible BOOLEAN DEFAULT FALSE,
    suggested_fix TEXT,
    reported_by VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    functional_area VARCHAR(100),
    assigned_to VARCHAR(50),
    comments TEXT,
    status ENUM('Open', 'In Progress', 'Resolved') NOT NULL DEFAULT 'Open',
    priority ENUM('Low', 'Medium', 'High') NOT NULL,
    resolution TEXT,
    resolution_version VARCHAR(50),
    resolved_by VARCHAR(50),
    resolved_date DATE,
    tested_by VARCHAR(50),
    tested_date DATE,
    deferred BOOLEAN DEFAULT FALSE
);

-- Inserting initial user data with SHA-256 hashed passwords
INSERT INTO users (username, password, userType) VALUES 
('admin', UNHEX(SHA2('password', 256)), 'admin'),
('employee', UNHEX(SHA2('password', 256)), 'employee');
