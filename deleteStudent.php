<?php
require_once('db_connect.php'); // Replace with your actual database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['studentId'];

    // Delete student from the room
    $query = "UPDATE students SET room_number = NULL WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $studentId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete student from the room']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
