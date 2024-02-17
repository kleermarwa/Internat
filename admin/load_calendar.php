<?php
include '../includes/db_connect.php';

if (isset($_POST['studentId'])) {
    $studentId = $_POST['studentId'];

    $query = "SELECT id, student_id, student_name, day_collected, week_start_date, week_end_date FROM ticket_history WHERE student_id = $studentId";
    $result = $conn->query($query);

    $events = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            // Increment the end date by one day to ensure it is inclusive
            $endDate = date('Y-m-d', strtotime($row['week_end_date'] . ' +1 day'));

            // If the collected day is Friday, add one more day
            if (date('N', strtotime($row['day_collected'])) == 5) { // 5 represents Friday
                $startDate = date('Y-m-d', strtotime($row['day_collected'] . ' +1 day'));
            } else {
                $startDate = $row['day_collected'];
            }

            $events[] = array(
                'start' => $startDate,
                'end' => $endDate,
                'color' => '#64E572',
                'extendedProps' => array(
                    'weekEndDate' => $row['week_end_date'],
                ),
            );
        }
    }

    echo json_encode($events);
}

$conn->close();
