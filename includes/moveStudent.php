<?php
require_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['studentId'];
    $action = $_POST['action'];
    $newRoomNumber = $_POST['newRoomNumber'];
    if (isset($_POST['genre'])) {
        $genre = $conn->real_escape_string($_POST['genre']);
    }

    if (isset($_POST['currentBuilding'])) {
        $currentBuilding = $_POST['currentBuilding'];
    } else if ($genre == 'boy') {
        $currentBuilding = 'boy';
    } else if ($genre == 'girl') {
        $currentBuilding = 'girl';
    }

    if ($currentBuilding == 'boy' && ($newRoomNumber <= 0 || $newRoomNumber > 110)) {
        echo json_encode(['success' => false, 'error' => 'Numéro de chambre invalide']);
        exit;
    } elseif ($currentBuilding == 'girl' && !(
        ($newRoomNumber >= 100 && $newRoomNumber <= 129) ||
        ($newRoomNumber >= 200 && $newRoomNumber <= 229) ||
        ($newRoomNumber >= 300 && $newRoomNumber <= 329) ||
        ($newRoomNumber >= 400 && $newRoomNumber <= 429)
    )) {
        echo json_encode(['success' => false, 'error' => 'Numéro de chambre invalide']);
        exit;
    }

    $stockQuery = "SELECT type FROM rooms WHERE building = ? AND room = ? ";
    $stockStmt = $conn->prepare($stockQuery);
    $stockStmt->bind_param('si', $currentBuilding, $newRoomNumber);
    $stockStmt->execute();
    $stockStmt->bind_result($type);
    $stockStmt->fetch();
    $stockStmt->close();

    if ($type == 'stock') {
        echo json_encode(['success' => false, 'error' => 'La chambre est de type stock']);
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
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $deletequery = "UPDATE internat SET status = 'Accepté' WHERE id_demande = ?";
            $deletestmt = $conn->prepare($deletequery);
            $deletestmt->bind_param('i', $id);
            $deletestmt->execute();
            $query = "UPDATE users SET room_number = ? , status = 'interne' WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ii', $newRoomNumber, $studentId);
        }
        if ($action == 'move') {
            $query = "UPDATE users SET room_number = ? , status = 'interne' WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ii', $newRoomNumber, $studentId);
            $historyquery = "INSERT INTO historique_internat (user_id, user_name, user_cin, old_room , new_room) ";
            $historyquery .= "VALUES (?, (SELECT name FROM users WHERE id = ?) , (SELECT cin FROM users WHERE id = ?) , (SELECT room_number FROM users WHERE id = ?) , ?)";
            $historystmt = $conn->prepare($historyquery);
            $historystmt->bind_param('iiiii', $studentId, $studentId, $studentId, $studentId, $newRoomNumber);
            $historystmt->execute();
        } elseif ($action == 'add') {
            isset($_POST['demande_id']) ? $demande_id = $_POST['demande_id'] : false;
            $query = "UPDATE users SET room_number = ? , status = 'interne' WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ii', $newRoomNumber, $studentId);
            $deletequery = "UPDATE internat SET status = 'Accepté' WHERE id_demande = ?";
            $deletestmt = $conn->prepare($deletequery);
            $deletestmt->bind_param('i', $demande_id);
            $deletestmt->execute();
        }
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to move student to another room']);
        }
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
