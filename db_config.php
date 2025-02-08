<?php
$host = "localhost";  // Server name (default: localhost)
$user = "root";       // MySQL username (default: root)
$pass = "";           // MySQL password (default: empty)
$dbname = "hospital_db"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>