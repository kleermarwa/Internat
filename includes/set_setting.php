<?php
include 'db_connect.php';
if (isset($_POST['phase']) && !empty($_POST['phase'])) {
    $phase = $_POST['phase'];
    if ($phase == 1) {
        $update_phase_sql = "UPDATE settings SET setting_value = 1 WHERE setting_name = 'phase'";
        $conn->query($update_phase_sql);
    } else if ($phase == 2) {
        $update_phase_sql = "UPDATE settings SET setting_value = 2 WHERE setting_name = 'phase'";
        $conn->query($update_phase_sql);
    }
}
if (isset($_POST['decharge']) && !empty($_POST['decharge'])) {
    $decharge = $_POST['decharge'];
    if ($decharge == 1) {
        $update_decharge_sql = "UPDATE settings SET setting_value = 1 WHERE setting_name = 'decharge'";
        $conn->query($update_decharge_sql);
    } else if ($decharge == 2) {
        $update_decharge_sql = "UPDATE settings SET setting_value = 2 WHERE setting_name = 'decharge'";
        $conn->query($update_decharge_sql);
    }
}
