<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST["action"];

    $sql = "SELECT historique_internat.*, users.*
        FROM historique_internat
        JOIN users ON historique_internat.user_id = users.id ";

    if ($action == 'search') {
        $searchText = $conn->real_escape_string($_POST['input']);
        $sql .= "AND (historique_internat.user_name LIKE '%$searchText%' OR historique_internat.user_cin LIKE '%$searchText%')";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $output = "<div class='RoomList'>";
        $output .= "<table id='data-table'>";
        $output .= "<thead><tr><th>Image</th><th>Nom de l'étudiant</th><th>Cin</th><th>Ancienne Chambre</th><th>Nouvelle Chambre</th><th>Fillière</th><th>Ville</th><th>Date de changement</th></tr></thead>";
        $output .= "<tbody>";

        while ($row = $result->fetch_assoc()) {
            $image = $row['image'];
            $output .= "<tr>";
            $output .= "<td> <img style='width: 100px; height: 100px; border-radius: 2px' src='$image' alt=''></td>";
            $output .= "<td>" . $row['user_name'] . "</td>";
            $output .= "<td>" . $row['cin'] . "</td>";
            $output .= "<td style='font-weight:bold; color:red'>" . $row['old_room'] . "</td>";
            $output .= "<td style='font-weight:bold; color:green'>" . $row['new_room'] . "</td>";
            $output .= "<td>" . $row['filliere'] . " " . $row['annee_scolaire'] . "</td>";
            $output .= "<td>" . $row['ville'] . "</td>";
            $output .= "<td>" . $date = date('d-m-Y', strtotime($row['date'])) . "</td>";
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
    echo "Error: This page cannot be accessed directly.";
}

$conn->close();
