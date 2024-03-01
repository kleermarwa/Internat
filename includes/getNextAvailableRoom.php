<?php
include '../includes/db_connect.php';

$genre = $conn->real_escape_string($_GET['genre']);

// Query to find the next available room for the specified genre
$sql = "SELECT room_id FROM rooms WHERE building = '$genre' AND num_students < 4 AND type != 'stock' ORDER BY room_id ASC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nextAvailableRoom = $row['room_id'];
    $query = "SELECT room FROM rooms WHERE room_id = $nextAvailableRoom";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $nextAvailableRoom = $row['room'];
    echo $nextAvailableRoom;
} else {
    echo "No available rooms";
}

$conn->close();
