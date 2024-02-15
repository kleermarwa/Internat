<?php
session_start();
include '../includes/db_connect.php';

// Get data from the AJAX request
$studentId = $_POST['studentId'];
$studentName = $_POST['studentName'];
$dayCollected = $_POST['dayCollected'];
$weekStartDate = $_POST['weekStartDate'];
$weekEndDate = $_POST['weekEndDate'];

// Check if a ticket already exists for the given week
$checkQuery = "SELECT id FROM ticket_history WHERE student_id = ? AND week_start_date = ? AND week_end_date = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("sss", $studentId, $weekStartDate, $weekEndDate);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    // Ticket already exists, display an error
    echo json_encode(['success' => false, 'message' => 'L\étudiant à déjà pris les tickets pour cette semaine']);
} else {
    // Insert data into the ticket_history table using prepared statement
    $insertQuery = "INSERT INTO ticket_history (student_id, student_name, day_collected, week_start_date, week_end_date) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("issss", $studentId, $studentName, $dayCollected, $weekStartDate, $weekEndDate);

    if ($insertStmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $insertStmt->error]);
    }
    $insertStmt->close();
}

// Close the prepared statements
$checkStmt->close();

// Close the database connection
$conn->close();
