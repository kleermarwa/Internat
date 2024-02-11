<?php
include '../includes/db_connect.php';

if (isset($_POST['studentId'])) {
    $studentId = $_POST['studentId'];

    $query = "SELECT id, student_id, student_name, week_start_date, week_end_date FROM ticket_history WHERE student_id = $studentId";
    $result = $conn->query($query);

    $events = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $events[] = array(
                'title' => 'Ticket Collected',
                'start' => $row['week_start_date'],
                'end' => $row['week_end_date'],
                'color' => '#64E572'
            );
        }
    }

    echo json_encode($events);
}

$conn->close();
