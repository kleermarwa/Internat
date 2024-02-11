<?php
include '../includes/db_connect.php';

if (isset($_POST['start']) && isset($_POST['end']) && isset($_POST['studentId']) && isset($_POST['studentName'])) {
    $start = $_POST['start'];
    $end = $_POST['end'];
    $id = $_POST['studentId'];
    $name = $_POST['studentName'];

    $query = "SELECT * FROM ticket_history WHERE student_id = ? AND week_start_date = ? AND week_end_date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $id, $start, $end);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "A record with the same date range already exists for this student.";
    } else {
        $sqlInsert = $conn->prepare("INSERT INTO ticket_history (student_id, student_name, week_start_date, week_end_date) VALUES (?, ?, ?, ?)");
        $sqlInsert->bind_param("ssss", $id, $name, $start, $end);

        if ($sqlInsert->execute() === TRUE) {
            echo "Ticket history inserted successfully";
        } else {
            echo "Error: " . $sqlInsert->error;
        }

        $sqlInsert->close();
    }

    $stmt->close();
    $conn->close();
}
