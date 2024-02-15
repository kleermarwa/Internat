<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the AJAX request
    $id = $_POST["id"];

    // Update the report field to 'Payé'
    $sql = "UPDATE degats SET report='Payé' WHERE id='$id';";

    if ($conn->query($sql) === TRUE) {
        echo "Paiement effectué avec succès!";
    } else {
        echo "Erreur lors du paiement: " . $conn->error;
    }
} else {
    echo "Erreur: Cette page ne peut être accédée directement.";
}
