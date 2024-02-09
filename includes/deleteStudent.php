<?php
require_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['studentId'];

    $query = "UPDATE users SET room_number = NULL, status = 'externe' WHERE id = ?";

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
