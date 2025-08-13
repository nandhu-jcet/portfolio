<?php

// Database credentials
$host = 'localhost';     // Hostname (default is localhost)
$user = 'root';          // Database username
$pass = '';              // Database password
$dbname = 'portfolio_db'; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character set to utf8mb4 for better compatibility
$conn->set_charset("utf8mb4");
?>
