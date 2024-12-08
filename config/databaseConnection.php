<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "librarysystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Function to test the database connection
function testDatabaseConnection($conn) {
    if ($conn->connect_error) {
        echo "Test failed: Connection failed: " . $conn->connect_error;
    } else {
        echo "Test passed: Successfully connected to the database.";
    }
}

// Run the test
testDatabaseConnection($conn);
?>