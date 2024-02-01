<?php
session_start();
include '../includes/db_connect.php';

if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];
    $name = $_GET['name'];
    $service = $_GET['service'];

    $updateSql = "UPDATE decharge ";

    switch ($service) {
        case '1':
            $updateSql .= "SET valide_departement = 1";
            break;
        case '2':
            $updateSql .= "SET valide_internat = 1";
            break;
        case '3':
            $updateSql .= "SET valide_economique = 1";
            break;
        case '4':
            $updateSql .= "SET valide_administration = 1 , status = 'Validé'";
            break;
    }

    $updateSql .= " WHERE id_demande = $request_id";

    if ($conn->query($updateSql) === TRUE) {
        $_SESSION['success'] = "La demande N° " . $request_id . " de l'étudiant: " . $name . " a été validé";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        $_SESSION['error'] = "La demande N° " . $request_id . " de l'étudiant: " . $name . " n'a pas été validé";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
} else {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
