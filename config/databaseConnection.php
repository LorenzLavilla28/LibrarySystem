<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "librarysystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Function to test the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
ob_end_clean();
?>