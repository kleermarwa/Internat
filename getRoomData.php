<?php
include 'db_connect.php';

// Get room number from the request
$roomNumber = $_GET['roomNumber'];

// Fetch student data for the given room
$sql = "SELECT * FROM students WHERE room_number = $roomNumber";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);
