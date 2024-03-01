<?php
include '../includes/db_connect.php';

// Get studentId from the URL parameter
$studentId = isset($_GET['studentId']) ? $_GET['studentId'] : null;

if ($studentId !== null) {
    // Fetch history records for the specified student
    $query = "SELECT * FROM historique_internat WHERE user_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();

    $result = $stmt->get_result();

    // Fetch records as an associative array
    $historyRecords = $result->fetch_all(MYSQLI_ASSOC);

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($historyRecords);
} else {
    // Invalid or missing studentId parameter
    echo json_encode(['error' => 'Invalid or missing studentId parameter']);
}
