<?php
include '../includes/db_connect.php';

$totalRooms = 110;

$queryBoys = "SELECT room_number, COUNT(*) AS count FROM students WHERE genre = 'boy' GROUP BY room_number";
$resultBoys = mysqli_query($conn, $queryBoys);

$emptyRoomsBoys = $totalRooms;
$roomsWithOneBoy = 0;
$roomsWithTwoBoys = 0;
$roomsWithThreeBoys = 0;
$roomFullBoys = 0;

while ($row = mysqli_fetch_assoc($resultBoys)) {
    $numberOfStudents = $row['count'];

    switch ($numberOfStudents) {
        case 0:
            $emptyRoomsBoys--;
            break;
        case 1:
            $roomsWithOneBoy++;
            $emptyRoomsBoys--;
            break;
        case 2:
            $roomsWithTwoBoys++;
            $emptyRoomsBoys--;
            break;
        case 3:
            $roomsWithThreeBoys++;
            $emptyRoomsBoys--;
            break;
        case 4:
            $roomFullBoys++;
            $emptyRoomsBoys--;
            break;
        default:
            break;
    }
}

$queryGirls = "SELECT room_number, COUNT(*) AS count FROM students WHERE genre = 'girl' GROUP BY room_number";
$resultGirls = mysqli_query($conn, $queryGirls);

$emptyRoomsGirls = $totalRooms;
$roomsWithOneGirl = 0;
$roomsWithTwoGirls = 0;
$roomsWithThreeGirls = 0;
$roomFullGirls = 0;

while ($row = mysqli_fetch_assoc($resultGirls)) {
    $numberOfStudents = $row['count'];

    switch ($numberOfStudents) {
        case 0:
            $emptyRoomsGirls--;
            break;
        case 1:
            $roomsWithOneGirl++;
            $emptyRoomsGirls--;
            break;
        case 2:
            $roomsWithTwoGirls++;
            $emptyRoomsGirls--;
            break;
        case 3:
            $roomsWithThreeGirls++;
            $emptyRoomsGirls--;
            break;
        case 4:
            $roomFullGirls++;
            $emptyRoomsGirls--;
            break;
        default:
            break;
    }
}

$data = array(
    "boys" => array(
        "emptyRooms" => $emptyRoomsBoys,
        "roomsWithOne" => $roomsWithOneBoy,
        "roomsWithTwo" => $roomsWithTwoBoys,
        "roomsWithThree" => $roomsWithThreeBoys,
        "roomFull" => $roomFullBoys,
    ),
    "girls" => array(
        "emptyRooms" => $emptyRoomsGirls,
        "roomsWithOne" => $roomsWithOneGirl,
        "roomsWithTwo" => $roomsWithTwoGirls,
        "roomsWithThree" => $roomsWithThreeGirls,
        "roomFull" => $roomFullGirls,
    )
);

echo json_encode($data);
