<?php
include '../includes/db_connect.php';

if (isset($_POST['studentId']) && isset($_POST['weekStartDate'])) {
    $studentId = $_POST['studentId'];
    $weekStartDate = $_POST['weekStartDate'];

    // Use a prepared statement to prevent SQL injection
    $query = "SELECT week_end_date FROM ticket_history WHERE student_id = ? AND week_start_date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $studentId, $weekStartDate);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($weekEndDate);
        $stmt->fetch();

        echo json_encode(['success' => true, 'weekEndDate' => $weekEndDate]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No records found for the student or invalid week start date.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters.']);
}

$conn->close();
?>
