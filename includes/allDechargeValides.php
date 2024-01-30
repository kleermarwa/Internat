<?php
include 'db_connect.php';

$sql = "SELECT decharge.*, students.*
        FROM decharge
        JOIN students ON decharge.student_id = students.id
        WHERE decharge.status = 'Validé';
        ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $output = "<div class='RoomList'>";
    $output .= "<table id='data-table'>";
    $output .= "<thead><tr><th>Numéro de requete</th><th>Nom de l'étudiant</th><th>Status</th><th>Filière</th><th>Date de création</th><th>Date de validation</th></tr></thead>";
    $output .= "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row['id_demande'] . "</td>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<td>" . $row['status'] . "</td>";
        $output .= "<td>" . $row['filliere'] . "</td>";
        $output .= "<td>" . $date = date('d-m-Y à H:i', strtotime($row['created_at'])) . "</td>";
        $output .= "<td>" . $date = date('d-m-Y à H:i', strtotime($row['updated_at'])) . "</td>";
        $output .= "</tr>";
    }

    $output .= "</tbody>";
    $output .= "</table>";
    $output .= "</div>";

    echo $output;
} else {
    echo "No results found.";
}
