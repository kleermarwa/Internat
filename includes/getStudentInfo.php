<?php
include 'db_connect.php';

$studentId = $_GET['studentId'];
$sql = "SELECT * FROM students WHERE id = $studentId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode([]);
}

$conn->close();
