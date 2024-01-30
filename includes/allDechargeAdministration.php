<?php
include 'db_connect.php';

$sql = "SELECT decharge.*, students.*
        FROM decharge
        JOIN students ON decharge.student_id = students.id
        WHERE decharge.status = 'pending';
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $output = "<div class='RoomList'>";
    $output .= "<table id='data-table'>";
    $output .= "<thead><tr><th>Numéro de requete</th><th>Nom de l'étudiant</th><th>Status</th><th>Filière</th><th>Date de création</th><th>Validé département</th><th>Validé internat</th><th>Validé Service Economique</th><th>Validé Administration</th></tr></thead>";
    $output .= "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $output .= "<tr style='text-align-last :center'>";
        $output .= "<td>" . $row['id_demande'] . "</td>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<td>" . $row['status'] . "</td>";
        $output .= "<td>" . $row['filliere'] . "</td>";
        $output .= "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";
        $output .= "<td style='font-weight:800 ;color: " . ($row['valide_departement'] ? 'green' : 'red') . "'>" . ($row['valide_departement'] ? '✔<br>Oui' : '❌<br>Non ') . " <br> <a class='validateDecharge' href='../admin/departement_validation.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "'>Valider</a></td>";
        $output .= "<td style='font-weight:800 ;color: " . ($row['valide_internat'] ? 'green' : 'red') . "'>" . ($row['valide_internat'] ? '✔<br>Oui' : '❌<br>Non ') . " <br> <a class='validateDecharge' href='../admin/internat_validation.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "'>Valider</a></td>";
        $output .= "<td style='font-weight:800 ;color: " . ($row['valide_economique'] ? 'green' : 'red') . "'>" . ($row['valide_economique'] ? '✔<br>Oui' : '❌<br>Non ') . " <br> <a class='validateDecharge' href='../admin/economique_validation.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "'>Valider</a></td>";
        $output .= "<td style='font-weight:800 ;color: " . ($row['valide_administration'] ? 'green' : 'red') . "'>" . ($row['valide_administration'] ? '✔<br>Oui' : '❌<br>Non ') . "<br> <a class='validateDecharge' href='../admin/administration_validation.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "'>Valider</a></td>";
        $output .= "</tr>";
    }

    $output .= "</tbody>";
    $output .= "</table>";
    $output .= "</div>";

    echo $output;
} else {
    echo "No results found.";
}
