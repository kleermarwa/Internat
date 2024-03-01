<?php
include('db_connect.php');

$building = $_GET['building'];
function getNumStudentsInRoom($roomId, $building)
{
    global $conn;

    if ($building == 'boy') {
        $query = "SELECT COUNT(*) as num_students FROM users WHERE room_number = ? AND status='interne' AND genre = 'boy'";
    } else {
        $query = "SELECT COUNT(*) as num_students FROM users WHERE room_number = ? AND status='interne' AND genre = 'girl'";
    }
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $stmt->bind_result($numStudents);
    $stmt->fetch();
    $stmt->close();

    return $numStudents;
}

$roomId = isset($_GET['roomId']) ? $_GET['roomId'] : null;

if ($roomId !== null && !empty($roomId)) {
    $numStudents = getNumStudentsInRoom($roomId, $building);
    echo json_encode(['success' => true, 'numStudents' => $numStudents]);
} else {
    echo json_encode(['success' => false, 'message' => 'Room ID not provided.']);
}

$conn->close();
