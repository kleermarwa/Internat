<?php
include 'db_connect.php';

global $conn;

$search_term = $_GET['term'];
$building = $_GET['building'];
// if ($building == 'girl') {
$stmt = $conn->prepare("SELECT id, name, image , room_number, status FROM users WHERE name LIKE ? AND genre = 'boy' AND status != 'admin'");
// }
// else {
//     $stmt = $conn->prepare("SELECT id, name, image , room_number, status FROM users WHERE name LIKE ? AND genre = 'girl' AND status != 'admin'");
// }

$search_term = "%$search_term%";
$stmt->bind_param('s', $search_term);
$stmt->execute();
$stmt->bind_result($id, $name, $image, $room_number, $status);
$search_results = array();

while ($stmt->fetch()) {
    $search_results[] = array(
        'id' => $id,
        'label' => $name,
        'value' => $name,
        'image' => $image,
        'roomNumber' => $room_number,
        'status' => $status
    );
}

$stmt->close();
$conn->close();
echo json_encode($search_results);
