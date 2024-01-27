<?php
include '../includes/user_info.php';
$userData = array(
    'id' => $user_id,
    'name' => $name,
    'email' => $email,
    'image' => $image,
    'gender' => $gender,
    'room_number' => $room,
    'date_naissance' => $date_naissance,
    'ville' => $ville,
    'status' => $status,
    'annee_scolaire' => $annee_scolaire,
    'user_image' => $user_image
);

echo json_encode($userData);
