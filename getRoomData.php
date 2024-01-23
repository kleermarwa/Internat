<?php
include 'db_connect.php';

// Get room number and building from the request
$roomNumber = $_GET['roomNumber'];
$building = $_GET['building'];

// Fetch student data for the given room and building
if ($building == 'boys') {
    $sql = "SELECT * FROM students WHERE room_number = $roomNumber AND genre = 'boy'";
} else {
    $sql = "SELECT * FROM students WHERE room_number = $roomNumber AND genre = 'girl'";
}

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$studentCount = count($data);

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);
