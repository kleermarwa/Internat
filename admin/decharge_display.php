<?php
session_start();
include '../includes/db_connect.php';

$sql = "SELECT decharge.*, users.*
        FROM decharge
        JOIN users ON decharge.student_id = users.id ";

if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'departement':
            $sql .= "WHERE decharge.status = 'En attente' AND decharge.valide_departement = 0;";
            break;
        case 'internat':
            $sql .= "WHERE decharge.status = 'En attente' AND decharge.valide_departement = 1 AND decharge.valide_internat = 0";
            break;
        case 'economique':
            $sql .= "WHERE decharge.status = 'En attente' AND decharge.valide_departement = 1 AND decharge.valide_internat = 1 AND decharge.valide_economique = 0";
            break;
        case 'administration':
            $sql .= "WHERE decharge.status = 'En attente'";
            break;
    }
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    if ($_SESSION['role'] == 'administration') {
        $output = "<div class='RoomList'>";
        $output .= "<table id='data-table'>";
        $output .= "<thead><tr><th>Numéro de requete</th><th>Nom de l'étudiant</th><th>Status</th><th>Filière</th><th>Date de création</th><th>Validé département</th><th>Validé internat</th></tr></thead>";
        $output .= "<tbody>";

        while ($row = $result->fetch_assoc()) {
            $output .= "<tr style='text-align-last :center'>";
            $output .= "<td>" . $row['id_demande'] . "</td>";
            $output .= "<td>" . $row['name'] . "</td>";
            $output .= "<td>" . $row['status'] . "</td>";
            $output .= "<td>" . $row['filliere'] . "</td>";
            $output .= "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";
            $output .= "<td style='font-weight:800 ;color: " . ($row['valide_departement'] ? 'green' : 'red') . "'>" . ($row['valide_departement'] ? '✔<br>Oui' : '❌<br>Non ') . " <br> <a class='validateDecharge' href='../admin/decharge_validation.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "&amp;service=1'>Valider</a></td>";
            $output .= "<td style='font-weight:800 ;color: " . ($row['valide_internat'] ? 'green' : 'red') . "'>" . ($row['valide_internat'] ? '✔<br>Oui' : '❌<br>Non ') . " <br> <a class='validateDecharge' href='../admin/decharge_validation.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "&amp;service=2'>Valider</a></td>";

            $output .= "</tr>";
        }

        $output .= "</tbody>";
        $output .= "</table>";
        $output .= "</div>";

        echo $output;
    } else {
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
            $output .= "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";

            $output .= "<td><a class='validateDecharge' href='../admin/decharge_validation.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "&amp;service=";

            switch ($_SESSION['role']) {
                case 'departement':
                    $output .= '1';
                    break;
                case 'internat':
                    $output .= '2';
                    break;
                case 'economique':
                    $output .= '3';
                    break;
                case 'administration':
                    $output .= '4';
                    break;
            }

            $output .= "'>Valider</a></td>";
            $output .= "</tr>";
        }

        $output .= "</tbody>";
        $output .= "</table>";
        $output .= "</div>";

        echo $output;
    }
} else {
    echo "Il n'y a aucune demande ";
}
