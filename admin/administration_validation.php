<?php
session_start();
include '../includes/db_connect.php';

if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];
    $name = $_GET['name'];

    $updateSql = "UPDATE decharge SET valide_administration = 1 , status = 'Validé' WHERE id_demande = $request_id";

    if ($conn->query($updateSql) === TRUE) {
        $_SESSION['success'] = "La demande N° " . $request_id . " de l'étudiant: " . $name . " a été validé";
        header("Location: administration_decharge.php");
        exit();
    } else {
        $_SESSION['error'] = "La demande N° " . $request_id . " de l'étudiant: " . $name . " n'a pas été validé";
        header("Location: administration_decharge.php?error=validation_error");
        exit();
    }
} else {
    header("Location: administration_decharge.php?error=invalid_request");
    exit();
}
