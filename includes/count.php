<?php
// Function to get the number of students in a room
function getNumberOfStudentsInRoom($conn, $roomId, $gender)
{
    $sql = "SELECT COUNT(*) AS num_students FROM students WHERE room_number = ? AND genre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $roomId, $gender);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['num_students'];
}
function getNumberOfRequestsInRoom($conn, $roomId, $gender)
{
    $sql = "SELECT COUNT(*) AS num_requests FROM internat WHERE room_number = ? AND genre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $roomId, $gender);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['num_requests'];
}
