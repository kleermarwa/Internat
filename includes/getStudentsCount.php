<?php
include('db_connect.php');

$building = $_GET['building'];
function getNumStudentsInRoom($roomId, $building)
{
    global $conn; 

    if ($building == 'boys') {
        $query = "SELECT COUNT(*) as num_students FROM students WHERE room_number = ? AND status='interne' AND genre = 'boy'";
    } else {
        $query = "SELECT COUNT(*) as num_students FROM students WHERE room_number = ? AND status='interne' AND genre = 'girl'";
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $roomId);

    // Execute the query
    $stmt->execute();

    // Bind the result variable
    $stmt->bind_result($numStudents);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
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
