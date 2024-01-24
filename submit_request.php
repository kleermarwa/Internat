<!-- submit_request.php -->
<?php
// Include your database connection and other necessary files
// ...

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_request'])) {
    // Assuming you have the student ID from the session
    $studentId = $_SESSION['student_id'];

    // Insert the request into the database
    $insertQuery = "INSERT INTO decharge (student_id) VALUES (?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param('i', $studentId);

    if ($insertStmt->execute()) {
        echo "Request submitted successfully!";
    } else {
        echo "Failed to submit request.";
    }

    $insertStmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
