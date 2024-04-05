<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_request'])) {

    $id = $_SESSION['user_id'];
    $userQuery = "SELECT name, genre, ville , pays FROM users WHERE id = $id";
    $userResult = $conn->query($userQuery);

    if ($userResult->num_rows > 0) {

        $userData = $userResult->fetch_assoc();
        $name = $userData['name'];
        $gender = $userData['genre'];
        $pays = $userData['pays'];
        $ville = $userData['ville'];
        if ($ville = 'Casablanca') {
            $valide = 0;
        }
        else {
            $valide = 1;
        }

        $check_demand_sql = "SELECT * FROM internat WHERE student_id = ?";
        $check_demand_stmt = $conn->prepare($check_demand_sql);
        $check_demand_stmt->bind_param('i', $id);
        $check_demand_stmt->execute();
        $demand_result = $check_demand_stmt->get_result();

        // Check if a student is external 
        $check_status_sql = "SELECT * FROM users WHERE name = ? AND status = 'externe' ";
        $check_status_stmt = $conn->prepare($check_status_sql);
        $check_status_stmt->bind_param('s', $name);
        $check_status_stmt->execute();
        $status_result = $check_status_stmt->get_result();

        if ($demand_result->num_rows > 0) {
            $_SESSION['error'] = "Vous avez déjà soumis une demande de décharge.";
            header('Location: ../students/internat.php');
            exit();
        } elseif ($status_result->num_rows > 0) {
            $insert_sql = "INSERT INTO internat (student_id, name, status, genre, ville, valide) 
                VALUES (?, ?, 'En attente', ?, ?,?)";

            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param('isssi', $id, $name, $gender, $ville , $valide);
            if ($insert_stmt->execute()) {
                $_SESSION['success'] = "Demande crée avec succes!";
                header('Location: ../students/internat.php');
            } else {
                echo "Failed to submit request.";
            }
        } else {
            echo "Error: Invalid request method.";
        }
    } else {
        echo "User not found";
    }
}
