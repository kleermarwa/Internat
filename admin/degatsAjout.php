<?php
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $cin = mysqli_real_escape_string($conn, $_POST['cin']);
    $materiel = mysqli_real_escape_string($conn, $_POST['materiel']);
    $montant = mysqli_real_escape_string($conn, $_POST['montant']);
    $commentaire = mysqli_real_escape_string($conn, $_POST['commentaire']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    $type == 'Incident' ? $report = 'Non payé' : $report = 'Non retourné';

    if (empty($cin) || empty($materiel) || empty($montant) || empty($commentaire)) {
        echo "Veuillez remplir tous les champs.";
        exit;
    }


    // Prepare the statement
    $insertQuery = "INSERT INTO degats (user_id, user_name, cin, materiel, montant, type, commentaire , report) ";
    $insertQuery .= "VALUES ((SELECT id FROM users WHERE cin = ?), ";
    $insertQuery .= "(SELECT name FROM users WHERE cin = ?), ?, ?, ?, ?, ? , ?)";

    $stmt = mysqli_prepare($conn, $insertQuery);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'ssssssss', $cin, $cin, $cin, $materiel, $montant, $type, $commentaire, $report);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request!";
}

mysqli_close($conn);
