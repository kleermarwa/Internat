<?php
include 'db_connect.php';
$action = $_GET["action"];

$sql = "SELECT decharge.*, users.*
        FROM decharge
        JOIN users ON decharge.student_id = users.id
        WHERE decharge.status = 'Validé'";

if ($action == 'loadInternat') {
    $sql .= " AND (users.status = 'Interne')";
}
if ($action == 'searchInternat') {
    $searchInput = $conn->real_escape_string($_GET['input']);
    $sql .= " AND (users.status = 'Interne') AND ((users.name LIKE '%$searchInput%') OR (decharge.id_demande LIKE '%$searchInput%'))";
}
if ($action == 'searchAdmin') {
    $searchInput = $conn->real_escape_string($_GET['input']);
    $sql .= " AND ((users.name LIKE '%$searchInput%') OR (decharge.id_demande LIKE '%$searchInput%'))";
}

$result = $conn->query($sql);


if ($result->num_rows > 0) {

    $output = "<div class='RoomList'>";
    $output .= "<table id='data-table'>";
    $output .= "<thead><tr><th>Numéro de requete</th><th>Nom de l'étudiant</th><th>".(($action == 'loadAdmin' || $action == 'searchAdmin') ? 'Status' : 'Chambre')."</th><th>Filière</th><th>Date de création</th><th>Date de validation</th></tr></thead>";
    $output .= "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row['id_demande'] . "</td>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<td>" . (($action == 'loadAdmin' || $action == 'searchAdmin') ? $row['status'] : $row['room_number']) . "</td>";
        $output .= "<td>" . $row['filliere'] . "</td>";
        $output .= "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";
        $output .= "<td>" . $date = date('d-m-Y à H:i', strtotime($row['updated_at'])) . "</td>";
        $output .= "</tr>";
    }

    $output .= "</tbody>";
    $output .= "</table>";
    $output .= "</div>";

    echo $output;
} else {
    echo "Il n'y a aucune demande ";
}
