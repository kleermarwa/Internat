<?php
require_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['studentId'];
    $newRoomNumber = $_POST['newRoomNumber'];
    $currentBuilding = $_POST['currentBuilding'];

    if ($newRoomNumber <= 0 || $newRoomNumber > 110) {
        echo json_encode(['success' => false, 'error' => 'Numéro de chambre invalide']);
        exit;
    }

    $countQuery = "SELECT COUNT(*) FROM students WHERE room_number = ? AND genre = ?";
    $countStmt = $conn->prepare($countQuery);
    $countStmt->bind_param('is', $newRoomNumber, $currentBuilding);
    $countStmt->execute();
    $countStmt->bind_result($numStudents);
    $countStmt->fetch();
    $countStmt->close();

    if ($numStudents >= 4) {
        echo json_encode(['success' => false, 'error' => 'La chambre est déjà pleine']);
        exit;
    }

    $query = "UPDATE students SET room_number = ? , status = 'interne' WHERE id = ?";
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
