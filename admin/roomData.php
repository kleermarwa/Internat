<?php
include '../includes/db_connect.php';

$totalRooms = 110;

$queryboy = "SELECT room_number, COUNT(*) AS count FROM users WHERE genre = 'boy' GROUP BY room_number";
$resultboy = mysqli_query($conn, $queryboy);

$emptyRoomsboy = $totalRooms;
$roomsWithOneBoy = 0;
$roomsWithTwoboy = 0;
$roomsWithThreeboy = 0;
$roomFullboy = 0;

while ($row = mysqli_fetch_assoc($resultboy)) {
    $numberOfStudents = $row['count'];

    switch ($numberOfStudents) {
        case 0:
            $emptyRoomsboy--;
            break;
        case 1:
            $roomsWithOneBoy++;
            $emptyRoomsboy--;
            break;
        case 2:
            $roomsWithTwoboy++;
            $emptyRoomsboy--;
            break;
        case 3:
            $roomsWithThreeboy++;
            $emptyRoomsboy--;
            break;
        case 4:
            $roomFullboy++;
            $emptyRoomsboy--;
            break;
        default:
            break;
    }
}

$querygirl = "SELECT room_number, COUNT(*) AS count FROM users WHERE genre = 'girl' GROUP BY room_number";
$resultgirl = mysqli_query($conn, $querygirl);

$emptyRoomsgirl = $totalRooms;
$roomsWithOneGirl = 0;
$roomsWithTwogirl = 0;
$roomsWithThreegirl = 0;
$roomFullgirl = 0;

while ($row = mysqli_fetch_assoc($resultgirl)) {
    $numberOfStudents = $row['count'];

    switch ($numberOfStudents) {
        case 0:
            $emptyRoomsgirl--;
            break;
        case 1:
            $roomsWithOneGirl++;
            $emptyRoomsgirl--;
            break;
        case 2:
            $roomsWithTwogirl++;
            $emptyRoomsgirl--;
            break;
        case 3:
            $roomsWithThreegirl++;
            $emptyRoomsgirl--;
            break;
        case 4:
            $roomFullgirl++;
            $emptyRoomsgirl--;
            break;
        default:
            break;
    }
}

$data = array(
    "boy" => array(
        "emptyRooms" => $emptyRoomsboy,
        "roomsWithOne" => $roomsWithOneBoy,
        "roomsWithTwo" => $roomsWithTwoboy,
        "roomsWithThree" => $roomsWithThreeboy,
        "roomFull" => $roomFullboy,
    ),
    "girl" => array(
        "emptyRooms" => $emptyRoomsgirl,
        "roomsWithOne" => $roomsWithOneGirl,
        "roomsWithTwo" => $roomsWithTwogirl,
        "roomsWithThree" => $roomsWithThreegirl,
        "roomFull" => $roomFullgirl,
    )
);

echo json_encode($data);
