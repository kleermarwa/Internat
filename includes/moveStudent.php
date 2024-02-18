<?php
require_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['studentId'];
    $newRoomNumber = $_POST['newRoomNumber'];
    if (isset($_POST['genre'])) {
        $genre = $conn->real_escape_string($_POST['genre']);
    }

    if (isset($_POST['currentBuilding'])) {
        $currentBuilding = $_POST['currentBuilding'];
    } else if ($genre == 'boy') {
        $currentBuilding = 'boys';
    } else if ($genre == 'girl') {
        $currentBuilding = 'girls';
    }

    if ($newRoomNumber <= 0 || $newRoomNumber > 110) {
        echo json_encode(['success' => false, 'error' => 'Numéro de chambre invalide']);
        exit;
    }

    $countQuery = "SELECT COUNT(*) FROM users WHERE room_number = ? AND genre = ?";
    $countStmt = $conn->prepare($countQuery);
    $countStmt->bind_param('is', $newRoomNumber, $currentBuilding);
    $countStmt->execute();
    $countStmt->bind_result($numStudents);
    $countStmt->fetch();
    $countStmt->close();

    if ($numStudents >= 4) {
        echo json_encode(['success' => false, 'error' => 'La chambre est déjà pleine']);
        exit;
    } else {

        $historyquery = "INSERT INTO historique_internat (user_id, user_name, user_cin, old_room , new_room) ";
        $historyquery .= "VALUES (?, (SELECT name FROM users WHERE id = ?) , (SELECT cin FROM users WHERE id = ?) , (SELECT room_number FROM users WHERE id = ?) , ?)";
        $historystmt = $conn->prepare($historyquery);
        $historystmt->bind_param('iiiii', $studentId, $studentId, $studentId, $studentId, $newRoomNumber);
        $historystmt->execute();

        $query = "UPDATE users SET room_number = ? , status = 'interne' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $newRoomNumber, $studentId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to move student to another room']);
        }
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $deletequery = "UPDATE internat SET status = 'Accepté' WHERE id_demande = ?";
            $deletestmt = $conn->prepare($deletequery);
            $deletestmt->bind_param('i', $id);
            $deletestmt->execute();
        }
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
