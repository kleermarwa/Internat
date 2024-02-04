<?php
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'student' ?  null :  header("Location:" . $_SESSION['defaultPage']);

$selectQuery = "SELECT decharge.*, students.*, students.status AS student_status , decharge.status AS decharge_status
                FROM decharge 
                JOIN students ON decharge.student_id = students.id 
                WHERE decharge.student_id = ?";
$selectStmt = $conn->prepare($selectQuery);
$selectStmt->bind_param('i', $user_id);
$selectStmt->execute();
$result = $selectStmt->get_result();


if ($result->num_rows > 0) {
    echo "<h3 style='text-align: center'>Votre demande de décharge précédente:</h3> <br>";
    echo "<p style='font-size:1.1rem ; text-align: center'>La validation se fait dans l'ordre présenté ce-dessous:</p>";
    echo "<div class='RoomList'>";
    echo "<table id='data-table'>";
    echo "<tr><th>Numéro de la demande</th><th>Date de soumission</th><th>Validé département</th><th>Validé internat</th><th>Validé Service Economique</th><th>Validé Administration</th><th>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $status = $row['decharge_status'];
        $student_status = $row['student_status'];
        $creationDate = new DateTime($row['created_at']);
        // $creationDate = new DateTime(date('Y') . '-04-01');
        $januaryFirst = new DateTime(date('Y') . '-01-01');
        $diff = $creationDate->diff($januaryFirst);
        $days = $diff->days;
        $halfMonths = ceil($days / 15);
        $accommodationFee = $halfMonths * 50;
        $restaurationFee = $halfMonths * 75;

        if ($row['student_status'] == 'interne') {
            $totalFee = $accommodationFee + $restaurationFee;
        } elseif ($row['student_status'] == 'externe') {
            $totalFee = 300;
        }
        $dep = $row['valide_departement'];
        $int = $row['valide_internat'];
        echo "<tr style='text-align-last :center'>";
        echo "<td>" . $row['id_demande'] . "</td>";
        echo "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['valide_departement'] ? 'green' : 'red') . "'>" . ($row['valide_departement'] ? '✔<br>Oui' : '❌<br>Non ') . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['valide_internat'] ? 'green' : 'red') . "'>" . ($row['valide_internat'] ? '✔<br>Oui' : '❌<br>Non ') . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['valide_economique'] ? 'green' : 'red') . "'>" . ($row['valide_economique'] ? '✔<br>Oui' : '❌<br>Non ') . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['valide_administration'] ? 'green' : 'red') . "'>" . ($row['valide_administration'] ? '✔<br>Oui' : '❌<br>Non ') . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['decharge_status'] == 'En attente' ? 'blue' : 'green') . "'>" . $row['decharge_status'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    if ($dep == 1 and $int == 1) {
        echo '<div style="text-align:center">';
        echo '<h6 style="font-weight:600;text-align:center">Cette attestation doit être imprimée et rendue au sevice économique pour finaliser la décharge</h6>';
        if ($student_status == 'interne') {
            echo '<p style="text-align:center; font-weight:800 ;color:red"> Il est impératif de régler ce montant lors du retour de ce document pour compléter intégralement la décharge, le montant étant calculé jusqu\'au jour de la soumission de la demande.</p>';
        } elseif ($student_status == 'externe') {
            echo '<p style="text-align:center; font-weight:800 ;color:red"> Il est impératif de régler ce montant pour les étudiants externe lors du retour de ce document pour compléter intégralement la décharge</p>';
        }
        echo "<p>Logement: $accommodationFee dh</p>";
        echo "<p>Restauration: $restaurationFee dh</p>";
        echo "<h5>Total : $totalFee dh</h5>";
        echo '<div class="discharge-container">';
        echo '<button class="discharge-button" onclick="redirect()">Télécharger Attestation';
        echo '<i class=" icon fa fa-file-pdf"></i>';
        echo '</button>';
        echo '</div>';
        echo '</div>';

    }
    echo "</div>";
} else {
    echo '<h2 style="text-align: center; margin-top:1rem">Demande de décharge</h2> <br>';
    echo '<h5 style="text-align: center">Vous n\'avez pas encore soumis de demandes de décharge.</h5> <br>';
    echo '<form class="discharge-container" action="submit_request.php" method="post">';
    echo '<button class="discharge-button" type="submit" name="create_request">Créer une demande</button>';
    echo '</form>';
}

$selectStmt->close();
$conn->close();
?>
<script>
    function redirect() {
        window.location.href = '../includes/pdfdecharge.php';
    }
</script>