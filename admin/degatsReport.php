<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $action = $_POST["action"];

    switch ($action) {
        case 'retourner':
            $sql = "UPDATE degats SET report='Retourné' WHERE id='$id';";
            break;
        case 'payer':
            $sql = "UPDATE degats SET report='Payé' WHERE id='$id';";
            break;

        default:
            echo "Invalid action parameter.";
            exit;
    }

    if ($conn->query($sql) === TRUE) {
        echo "Action performed successfully!";
    } else {
        echo "Error performing action: " . $conn->error;
    }
} else {
    echo "Error: This page cannot be accessed directly.";
}
