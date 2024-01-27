<?php
session_start();
include '../includes/db_connect.php';

if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    $updateSql = "DELETE FROM internat WHERE id_demande = $request_id";

    if ($conn->query($updateSql) === TRUE) {
        $_SESSION['success'] = "La demande N° " . $request_id . " a été annulée";
        header("Location: internat.php");
        exit();
    } else {
        $_SESSION['error'] = "La demande N° " . $request_id . " n'a pas été annulée";
        header("Location: internat.php?error=validation_error");
        exit();
    }
} else {
    header("Location: internat.php?error=invalid_request");
    exit();
}
