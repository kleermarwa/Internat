<?php
include 'db_connect.php';

// Get studentId from the GET request
$studentId = $_GET['studentId'];

// Fetch student details from the database
$sql = "SELECT * FROM students WHERE id = $studentId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Return student details as JSON
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    // If student not found, return an empty JSON object or handle it accordingly
    echo json_encode([]);
}

$conn->close();
