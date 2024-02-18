<?php
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'student' ?  null :  header("Location:" . $_SESSION['defaultPage']);

$selectQuery = "SELECT * FROM internat WHERE student_id = ?";
$selectStmt = $conn->prepare($selectQuery);
$selectStmt->bind_param('i', $user_id);
$selectStmt->execute();
$result = $selectStmt->get_result();

$userQuery = "SELECT * FROM users WHERE id = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param('i', $user_id);
$userStmt->execute();
$data = $userStmt->get_result();


echo "<h3 style='text-align: center'>Votre demande d'internat précédente:</h3>";
if ($result->num_rows > 0) {
    echo "<div class='RoomList'>";
    echo "<table id='data-table'>";
    echo "<tr><th>Numéro de la demande</th><th>Date de soumission</th><th>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];
        echo "<tr>";
        echo "<td>" . $row['id_demande'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "<td style='text-transform:capitalize'>" . $row['status'] . "</td>";
        echo $row['status'] == 'En attente' ? "<td><a class='reject' href='annuler_demande_internat.php?request_id=" . $row['id_demande'] . "&amp;name=" . urlencode($row['name']) . "'>Annuler demande</a>" : "</td>";
        echo "</tr>";
    }

    echo "</table>";
    while ($row = $data->fetch_assoc()) {
        $ville = $row['ville'];
        if ($ville !== 'Casablanca') {
            echo '<div class="discharge-container">';
            echo '<button class="discharge-button" onclick="redirect()">Télécharger Attestation';
            echo '<i class=" icon fa fa-file-pdf"></i>';
            echo '</button>';
            echo '</div>';
        }
        echo "</div>";
    }
} else {
    echo '<h5 style="text-align: center">Vous n\'avez pas encore soumis de demandes d\'internat.</h5> <br>';
    echo '<form class="discharge-container" action="../includes/demanderChambre.php" method="post">';
    echo '<button class="discharge-button" type="submit" name="create_request">Créer une demande</button>';
    echo '</form>';
}
$selectStmt->close();
$conn->close();
?>
<script>
    function redirect() {
        window.location.href = '../includes/pdf.php';
    }
</script>