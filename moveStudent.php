<?php
require_once('db_connect.php'); // Replace with your actual database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['studentId'];
    $newRoomNumber = $_POST['newRoomNumber'];

    // Check if the new room is valid (less than or equal to 110)
    if ($newRoomNumber <= 0 || $newRoomNumber > 110) {
        echo json_encode(['success' => false, 'error' => 'Invalid room number']);
        exit;
    }

    // Check if the room is already full (4 students)
    $countQuery = "SELECT COUNT(*) FROM students WHERE room_number = ?";
    
    $countStmt = $conn->prepare($countQuery);
    $countStmt->bind_param('i', $newRoomNumber);
    $countStmt->execute();
    $countStmt->bind_result($numStudents);
    $countStmt->fetch();
    $countStmt->close();

    if ($numStudents >= 4) {
        echo json_encode(['success' => false, 'error' => 'Room is already full']);
        exit;
    }

    // Move student to another room
    $query = "UPDATE students SET room_number = ? WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $newRoomNumber, $studentId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to move student to another room']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}