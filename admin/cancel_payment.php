<?php
session_start();
include '../includes/db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming the trimester and id values are posted
    $trimester = $_POST['trimester'];
    $id = $_POST['id'];

    // Validate and sanitize the input values
    $trimester = filter_var($trimester, FILTER_VALIDATE_INT);
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($trimester === false || $id === false) {
        // Invalid input values
        echo json_encode(['success' => false, 'error' => 'Invalid input values']);
        exit;
    }

    // Perform the cancellation operation using prepared statements
    $sql = "DELETE FROM paiements WHERE trimestre = ? AND user_id = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Error preparing statement: ' . $conn->error]);
        exit;
    }

    // Bind parameters
    $stmt->bind_param("ii", $trimester, $id);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        // Cancellation successful
        echo json_encode(['success' => true, 'message' => 'Annulation réussie!']);
    } else {
        // Cancellation failed
        echo json_encode(['success' => false, 'error' => 'Error processing cancellation: ' . $stmt->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

// Close the database connection
$conn->close();
?>
