<?php
include 'db_connect.php';
include '../includes/count.php';

$sql = "SELECT internat.*, users.*, internat.room_number AS room_alias
        FROM internat
        JOIN users ON internat.student_id = users.id
        WHERE internat.ville = 'Casablanca'
        AND internat.status = 'En attente'
        AND internat.valide = 0";

if (isset($_GET['input']) && !empty($_GET['input'])) {
    $searchInput = $conn->real_escape_string($_GET['input']);
    $sql .= " AND ((users.name LIKE '%$searchInput%') OR (internat.id_demande LIKE '%$searchInput%'))";
} elseif (isset($_GET['inputRoom']) && !empty($_GET['inputRoom'])) {
    $searchInput = $conn->real_escape_string($_GET['inputRoom']);
    $sql .= " AND internat.room_number LIKE '%$searchInput%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $output = "<div class='RoomList'>";
    $output .= "<table id='data-table'>";
    $output .= "<thead><tr><th>Numéro de demande</th><th>Nom de l'étudiant</th><th>Sexe</th><th>Date de création</th><th colspan=2>Action</th></tr></thead>";
    $output .= "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $numStudentsInRoom = getNumberOfStudentsInRoom($conn, $row['room_alias'], $row['genre']);
        $numRequestsInRoom = getNumberOfRequestsInRoom($conn, $row['room_alias'], $row['genre']);
        $output .= "<tr>";
        $output .= "<td>" . $row['id_demande'] . "</td>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<td>" . ($row['genre'] == 'boy' ? 'Garçon' : 'Fille') . "</td>";

        $output .= "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";
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
