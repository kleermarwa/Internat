<?php
include 'db_connect.php';
include 'count.php';

$sql = "SELECT internat.*, students.*, internat.room_number AS room_alias
        FROM internat
        JOIN students ON internat.student_id = students.id
        WHERE students.ville != 'Casablanca'
        AND internat.status = 'En attente'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $output = "<div class='RoomList'>";
    $output .= "<table id='data-table'>";
    $output .= "<thead><tr><th>Numéro de demande</th><th>Nom de l'étudiant</th><th>Sexe</th><th>Ville</th><th>Date de création</th><th>Numéro de chambre</th><th>Nombre d'étudiants dans la chambre</th><th>Nombre de demandes pour la chambre</th><th colspan=2>Action</th></tr></thead>";
    $output .= "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $numStudentsInRoom = getNumberOfStudentsInRoom($conn, $row['room_alias'], $row['genre']);
        $numRequestsInRoom = getNumberOfRequestsInRoom($conn, $row['room_alias'], $row['genre']);
        $output .= "<tr>";
        $output .= "<td>" . $row['id_demande'] . "</td>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<td>" . ($row['genre'] == 'boy' ? 'Garçon' : 'Fille') . "</td>";

        $output .= "<td>" . $row['ville'] . "</td>";
        $output .= "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";
        $output .= "<td>" . $row['room_alias'] . "</td>";
        $output .= "<td style='font-weight:bold;" . ($numStudentsInRoom == 4 ? 'color:red;' : 'color:green;') . "'>" . $numStudentsInRoom . "</td>";
        $output .= "<td>" . $numRequestsInRoom . "</td>";
        $output .= "<td style='border-right: none;'><a class='validate' href='internat_demandes_validation.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "'>Valider</a></td>";
        $output .= "<td style='border-left: none;'><a class='reject' href='internat_demandes_rejection.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "'>Rejeter</a></td>";
        $output .= "</tr>";
    }

    $output .= "</tbody>";
    $output .= "</table>";
    $output .= "</div>";

    echo $output;
} else {
    echo "Il n'y a aucune demande ";
}
