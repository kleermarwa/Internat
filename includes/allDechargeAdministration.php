<?php
// Include database connection
include 'db_connect.php';

// Construct the SQL query to fetch all results
$sql = "SELECT decharge.*, students.*
        FROM decharge
        JOIN students ON decharge.student_id = students.id
        WHERE decharge.status = 'pending' AND decharge.valide_departement = 1 AND decharge.valide_internat = 1 AND decharge.valide_economique = 1 AND decharge.valide_administration = 0;
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Prepare the HTML for displaying all results
    $output = "<div class='RoomList'>";
    $output .= "<table id='data-table'>";
    $output .= "<thead><tr><th>Numéro de requete</th><th>Nom de l'étudiant</th><th>Status</th><th>Filière</th><th>Date de création</th><th>Action</th></tr></thead>";
    $output .= "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row['id_demande'] . "</td>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<td>" . $row['status'] . "</td>";
        $output .= "<td>" . $row['filliere'] . "</td>";
        $output .= "<td>" . $row['created_at'] . "</td>";
        // Action button to validate the request
        $output .= "<td><a class='validateDecharge' href='internat_validation.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "'>Validate</a></td>";
        $output .= "</tr>";
    }

    $output .= "</tbody>";
    $output .= "</table>";
    $output .= "</div>";

    echo $output;
} else {
    echo "No results found.";
}
