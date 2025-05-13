<?php
// Database configuration
$host = "localhost";
$username = "root";  // Your MySQL username
$password = "";      // Your MySQL password
$database = "library_managemnentdb";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");
?> 