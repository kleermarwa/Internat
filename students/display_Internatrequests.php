<?php
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'student' ?  null :  header("Location:" . $_SESSION['defaultPage']);

$selectQuery = "SELECT * FROM internat WHERE student_id = ?";
$selectStmt = $conn->prepare($selectQuery);
$selectStmt->bind_param('i', $user_id);
$selectStmt->execute();
$result = $selectStmt->get_result();

echo "<h3 style='text-align: center'>Votre demande d'internat précédente:</h3>";
if ($result->num_rows > 0) {
    echo "<div class='RoomList'>";
    echo "<table id='data-table'>";
    echo "<tr><th>Numéro de la demande</th><th>Chambre demandée</th><th>Date de soumission</th><th>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id_demande'] . "</td>";
        echo "<td>" . $row['room_number'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo $row['valide'] == 0 ? "<td><a class='reject' href='annuler_demande_internat.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "'>Annuler demande</a>" : "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
} else {
    echo "Vous n'avez pas soumis de demandes de d'internat.";
}

$selectStmt->close();
$conn->close();
