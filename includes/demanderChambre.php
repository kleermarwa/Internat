<?php
session_start();
// Include the database connection file
include '../includes/db_connect.php';

// Check if the data is sent via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from the POST request
    $roomNumber = $_POST['roomNumber'];
    $id = $_POST['id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $ville = $_POST['ville'];

    // Check if a demand with the same ID exists
    $check_demand_sql = "SELECT * FROM internat WHERE student_id = ?";
    $check_demand_stmt = $conn->prepare($check_demand_sql);
    $check_demand_stmt->bind_param('i', $id);
    $check_demand_stmt->execute();
    $demand_result = $check_demand_stmt->get_result();

    // Check if a student with the same name exists in the same room
    $check_student_sql = "SELECT * FROM students WHERE name = ? AND room_number = ?";
    $check_student_stmt = $conn->prepare($check_student_sql);
    $check_student_stmt->bind_param('si', $name, $roomNumber);
    $check_student_stmt->execute();
    $student_result = $check_student_stmt->get_result();

    // Check if a student is external 
    $check_status_sql = "SELECT * FROM students WHERE name = ? AND status = 'externe' ";
    $check_status_stmt = $conn->prepare($check_status_sql);
    $check_status_stmt->bind_param('s', $name);
    $check_status_stmt->execute();
    $status_result = $check_status_stmt->get_result();

    if ($demand_result->num_rows > 0) {
        // If a demand with the same ID exists, return error message
        $response = array("success" => false, "message" => "Erreur : Une demande avec le même ID existe déjà.");
        echo json_encode($response);
    } elseif ($student_result->num_rows > 0) {
        $response = array("success" => false, "message" => "Etudiant existe déja dans la chambre N° " . $roomNumber);
        echo json_encode($response);
    } elseif ($status_result->num_rows > 0) {
        // Prepare the SQL statement to insert data into the database table
        $insert_sql = "INSERT INTO internat (student_id, name, room_number, status, genre, ville,valide) 
                VALUES (?, ?, ?, 'pending', ?, ?,0)";

        // Prepare the SQL statement
        $insert_stmt = $conn->prepare($insert_sql);

        // Bind parameters
        $insert_stmt->bind_param('isiss', $id, $name, $roomNumber, $gender, $ville);

        // Attempt to execute the prepared statement
        if ($insert_stmt->execute()) {
            $response = array("success" => true, "message" => "La demande à été effectuée avec succès - N° Chambre " . $roomNumber);
            echo json_encode($response);
        } else {
            // Return error message if insertion fails
            $response = array("success" => false, "message" => "Error: Unable to add demand.");
            echo json_encode($response);
        }
    }
} else {
    // Return error if request method is not POST
    echo "Error: Invalid request method.";
}
