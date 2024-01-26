<?php
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'student' ?  null :  header("Location:" . $_SESSION['defaultPage']);

session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_request'])) {
    $studentId = $_SESSION['student_id'];

    $selectQuery = "SELECT * FROM decharge WHERE student_id = ?";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param('i', $studentId);
    $selectStmt->execute();
    $result = $selectStmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Vous avez déjà soumis une demande de décharge.";
        header('Location: decharge.php');
        exit();
    } else {
        $insertQuery = "INSERT INTO decharge (student_id) VALUES (?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('i', $studentId);

        if ($insertStmt->execute()) {
            $_SESSION['success'] = "Demande crée avec succes!";
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
