<?php

// Include your database connection logic (db_connect.php or similar)
include 'db_connect.php';

// Check if request_id is set in the URL
if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    // Update the database to mark the request as validated by the department
    $updateSql = "UPDATE decharge SET valide_departement = 1 WHERE id_demande = $request_id";

    if ($conn->query($updateSql) === TRUE) {
        $_SESSION['success'] = "Demande" . $request_id . "Validé";
        header("Location: departement_decharge.php");
        exit();
    } else {
        $_SESSION['error'] = "Demande" . $request_id . "Non Validé";
        header("Location: departement_decharge.php?error=validation_error");
        exit();
    }
} else {
    // Invalid request: Redirect with an error message
    header("Location: decharge.php?error=invalid_request");
    exit();
}
