<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_request'])) {
    $studentId = 1;

    $selectQuery = "SELECT * FROM decharge WHERE student_id = ?";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param('i', $studentId);
    $selectStmt->execute();
    $result = $selectStmt->get_result();

    if ($result->num_rows > 0) {
        echo "You have already submitted a discharge request.";
    } else {
        $insertQuery = "INSERT INTO decharge (student_id) VALUES (?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('i', $studentId);

        if ($insertStmt->execute()) {
            header('Location: decharge.php');
            exit();
        } else {
            echo "Failed to submit request.";
        }
        $insertStmt->close();
        $conn->close();
    }
} else {
    echo "Invalid request method.";
}
