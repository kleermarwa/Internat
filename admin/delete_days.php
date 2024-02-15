<?php
include '../includes/db_connect.php';

// Ensure that the POST variables are set
if (isset($_POST['studentId'], $_POST['daysDifference'], $_POST['weekStartDate'])) {
    $studentId = $_POST['studentId'];
    $daysDifference = $_POST['daysDifference'];
    $weekStartDate = $_POST['weekStartDate'];

    // Use prepared statement to prevent SQL injection
    $query = "UPDATE ticket_history SET week_end_date = DATE_SUB(week_end_date, INTERVAL ? DAY) WHERE student_id = ? AND week_start_date = ?";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bind_param("iis", $daysDifference, $studentId, $weekStartDate);

    // Execute the query
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Days subtracted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error subtracting days: ' . $stmt->error]);
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters.']);
}

// Close the database connection
$conn->close();
