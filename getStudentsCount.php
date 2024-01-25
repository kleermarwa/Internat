<?php
// Include your database connection file
include('db_connect.php');

    $building = $_GET['building'];

// Function to get the number of students in a room
function getNumStudentsInRoom($roomId, $building)
{
    global $conn; // Assuming $conn is your database connection object

    // Perform a query to count the number of students in the specified room
    if ($building == 'boys') {
        $query = "SELECT COUNT(*) as num_students FROM students WHERE room_number = ? AND status='interne' AND genre = 'boy'";
    } else {
        $query = "SELECT COUNT(*) as num_students FROM students WHERE room_number = ? AND status='interne' AND genre = 'girl'";
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $roomId);

    // Execute the query
    $stmt->execute();

    // Bind the result variable
    $stmt->bind_result($numStudents);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    return $numStudents;
}

// Get the room ID from the request (assumes it's sent via POST)
$roomId = isset($_GET['roomId']) ? $_GET['roomId'] : null;

// Check if roomId is set and not empty
if ($roomId !== null && !empty($roomId)) {
    // Call the function and echo the result
    $numStudents = getNumStudentsInRoom($roomId,$building);
    echo json_encode(['success' => true, 'numStudents' => $numStudents]);
} else {
    // Return an error if roomId is not provided
    echo json_encode(['success' => false, 'message' => 'Room ID not provided.']);
}

// Close the database connection
$conn->close();
