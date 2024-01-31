<?php
session_start();
include '../includes/db_connect.php';

if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];
    $name = $_GET['name'];

    $updateSql = "UPDATE internat SET status = 'refusé' WHERE id_demande = $request_id";

    if ($conn->query($updateSql) === TRUE) {
        $_SESSION['success'] = "La demande N° " . $request_id . " de l'étudiant: " . $name . " a été rejetée";
        header("Location: internat_demandes.php");
        exit();
    } else {
        $_SESSION['error'] = "La demande N° " . $request_id . " de l'étudiant: " . $name . " n'a pas été rejetée";
        header("Location: internat_demandes.php?error=validation_error");
        exit();
    }
} else {
    header("Location: internat_decharge.php?error=invalid_request");
    exit();
}
