<?php
include 'db_connect.php';
if (isset($_GET['input']) && !empty($_GET['input'])) {
    $searchInput = $conn->real_escape_string($_GET['input']);
    $sql = "SELECT decharge.*, users.*
            FROM decharge
            JOIN users ON decharge.student_id = users.id
            WHERE (decharge.status = 'Validé' AND decharge.valide_departement = 1 AND decharge.valide_internat = 1 AND decharge.valide_economique = 1 AND decharge.valide_administration = 1) AND(
                  (users.name LIKE '%$searchInput%') OR (decharge.id_demande LIKE '%$searchInput%'))";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $output = "<div class='RoomList'>";
        $output .= "<table id='data-table'>";
        $output .= "<thead><tr><th>Numéro de requete</th><th>Nom de l'étudiant</th><th>Status</th><th>Filière</th><th>Date de création</th></tr></thead>";
        $output .= "<tbody>";

        while ($row = $result->fetch_assoc()) {
            $output .= "<tr>";
            $output .= "<td>" . $row['id_demande'] . "</td>";
            $output .= "<td>" . $row['name'] . "</td>";
            $output .= "<td>" . $row['status'] . "</td>";
            $output .= "<td>" . $row['filliere'] . "</td>";
            $output .= "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";
            $output .= "</tr>";
        }

        $output .= "</tbody>";
        $output .= "</table>";
        $output .= "</div>";

        echo $output;
    } else {
        echo "Il n'y a aucune demande ";
    }
} else {
    echo "Invalid input.";
}
