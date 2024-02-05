<?php
include 'db_connect.php';
include '../includes/count.php';

$previous_page = $_SERVER['HTTP_REFERER'];

if (isset($_GET['input']) && !empty($_GET['input'])) {
    $searchInput = $conn->real_escape_string($_GET['input']);
    $sql = "SELECT * FROM internat ";

    $sql = "SELECT internat.*, students.*, internat.room_number AS room_alias
        FROM internat
        JOIN students ON internat.student_id = students.id ";

    if (strpos($previous_page, 'internat_demandes_valide.php') !== false) {
        $sql .= "WHERE internat.status = 'Accepté'";
    } elseif (strpos($previous_page, 'internat_demandes_refuse.php') !== false) {
        $sql .= "WHERE internat.status = 'Refusé'";
    }

    $sql .= " AND ((students.name LIKE '%$searchInput%') OR (internat.id_demande LIKE '%$searchInput%'))";

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
            if (strpos($previous_page, 'internat_demandes_valide.php') !== false) {

                $output .= "<td><button " . ($numStudentsInRoom == 4 ? "disabled" : "") . " class='add-student blue' data-id='" . $row['id_demande'] . "' data-room-alias='" . $row['room_alias'] . "' data-student-id='" . $row['id'] . "' data-genre='" . $row['genre'] . "' title='" . ($numStudentsInRoom == 4 ? "Impossible dֻe rajouter des étudiants additionnels à cette chambre" : '') . "' style='cursor: " . ($numStudentsInRoom == 4 ? 'not-allowed' : 'pointer') . "'>Ajouter chambre</button></td>";

                $output .= "<td><button class='cancel-validation reject' data-id='" . $row['id_demande'] . "'>Annuler validation</button></td>";
            } elseif (strpos($previous_page, 'internat_demandes_refuse.php') !== false) {
                $output .= "<td><button style='margin: 0 auto 0 auto;' class='validate-request validate' data-id='" . $row['id_demande'] . "''>Valider</button></td>";
            }
            $output .= "</tr>";
        }

        $output .= "</tbody>";
        $output .= "</table>";
        $output .= "</div>";

        echo $output;
    } else {
        echo "Il n'y a aucune demande ";
    }
}
