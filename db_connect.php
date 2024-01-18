<?php
// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = "aqw7410ol:9630";
$dbname = "estc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
