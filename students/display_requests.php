<?php
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'student' ?  null :  header("Location:" . $_SESSION['defaultPage']);

$selectQuery = "SELECT * FROM decharge WHERE student_id = ?";
$selectStmt = $conn->prepare($selectQuery);
$selectStmt->bind_param('i', $user_id);
$selectStmt->execute();
$result = $selectStmt->get_result();

echo "<h3 style='text-align: center'>Votre demande de décharge précédente:</h3> <br>";
echo "<p style='font-size:1.1rem ; text-align: center'>La validation se fait dans l'ordre présenté ce-dessous:</p>";
if ($result->num_rows > 0) {
    echo "<div class='RoomList'>";
    echo "<table id='data-table'>";
    echo "<tr><th>Numéro de la demande</th><th>Date de soumission</th><th>Validé département</th><th>Validé internat</th><th>Validé Service Economique</th><th>Validé Administration</th><th>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];
        echo "<tr style='text-align-last :center'>";
        echo "<td>" . $row['id_demande'] . "</td>";
        echo "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['valide_departement'] ? 'green' : 'red') . "'>" . ($row['valide_departement'] ? '✔<br>Oui' : '❌<br>Non ') . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['valide_internat'] ? 'green' : 'red') . "'>" . ($row['valide_internat'] ? '✔<br>Oui' : '❌<br>Non ') . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['valide_economique'] ? 'green' : 'red') . "'>" . ($row['valide_economique'] ? '✔<br>Oui' : '❌<br>Non ') . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['valide_administration'] ? 'green' : 'red') . "'>" . ($row['valide_administration'] ? '✔<br>Oui' : '❌<br>Non ') . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['status'] == 'Pending' ? 'blue' : 'green') . "'>" . ($row['status'] == 'Pending' ? 'En Attente' : 'Validé') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    if ($status == 'Validé') {
        echo '<div class="discharge-container">';
        echo '<button class="discharge-button" onclick="redirect()">Télécharger Attestation';
        echo '<i class=" icon fa fa-file-pdf"></i>';
        echo '</button>';
        echo '</div>';
    }
    echo "</div>";
} else {
    echo "Vous n'avez pas encore soumis de demandes de décharge.";
}

$selectStmt->close();
$conn->close();
?>
<script>
    function redirect() {
        window.location.href = '../includes/pdfdecharge.php';
    }
</script>
