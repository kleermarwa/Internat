<?php
include 'db_connect.php';

$sql = "SELECT * FROM internat WHERE ville != 'Casablanca' AND valide = 0";

$result = $conn->query($sql);

if ($result->num_rows > 0) {    
    $output = "<div class='RoomList'>";
    $output .= "<table id='data-table'>";
    $output .= "<thead><tr><th>Numéro de demande</th><th>Nom de l'étudiant</th><th>Ville</th><th>Numéro de chambre</th><th>Status</th><th>Genre</th><th>Date de création</th><th colspan=2>Action</th></tr></thead>";
    $output .= "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row['id_demande'] . "</td>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<td>" . $row['ville'] . "</td>";
        $output .= "<td>" . $row['room_number'] . "</td>";
        $output .= "<td>" . $row['status'] . "</td>";
        $output .= "<td>" . $row['genre'] . "</td>";
        $output .= "<td>" . $row['created_at'] . "</td>";
        $output .= "<td style='border-right: none;'><a class='validate' href='demande_internat_validation.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "'>Validate</a></td>";
        $output .= "<td style='border-left: none;'><a class='reject' href='demande_internat_rejection.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "'>Rejeter</a></td>";
        $output .= "</tr>";
    }

    $output .= "</tbody>";
    $output .= "</table>";
    $output .= "</div>";

    echo $output;
} else {
    echo "No results found.";
}
