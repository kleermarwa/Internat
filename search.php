<?php
// Connect to the database and check for errors in the connection
include 'db_connect.php';

global $conn;

// Get the search term from the AJAX request
$search_term = $_GET['term'];
$building = $_GET['building'];

// Prepare SQL query
if ($building == 'boys') {
    $stmt = $conn->prepare("SELECT id, name, image , room_number FROM students WHERE name LIKE ? AND genre = 'boy'");
} else {
    $stmt = $conn->prepare("SELECT id, name, image , room_number FROM students WHERE name LIKE ? AND genre = 'girl'");
}
$search_term = "%$search_term%";
$stmt->bind_param('s', $search_term);
$stmt->execute();
$stmt->bind_result($id, $name, $image, $room_number);

// Build the search results array
$search_results = array();
while ($stmt->fetch()) {
    $search_results[] = array(
        'id' => $id,
        'label' => $name,
        'value' => $name,
        'image' => $image,
        'roomNumber' => $room_number
    );
}

// Close the database connection and return the search results as JSON
$stmt->close();
$conn->close();
echo json_encode($search_results);
