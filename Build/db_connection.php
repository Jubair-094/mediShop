<?php
$servername = "localhost";
$username = "root";
$password = "";  // Default password for XAMPP's MySQL is empty
$dbname = "medical_shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>