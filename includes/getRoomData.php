<?php
include 'db_connect.php';

$roomNumber = $_GET['roomNumber'];
$building = $_GET['building'];
if ($building == 'boys') {
    $sql = "SELECT * FROM students WHERE room_number = $roomNumber AND status='interne' AND genre = 'boy'";
} else {
    $sql = "SELECT * FROM students WHERE room_number = $roomNumber AND status='interne' AND genre = 'girl'";
}

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$studentCount = count($data);
$conn->close();
header('Content-Type: application/json');
echo json_encode($data);
