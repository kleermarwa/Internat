<?php
// Check user role and redirect if not authorized
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'super_admin' && $_SESSION['role'] != 'student')) {
    header("Location: " . $_SESSION['defaultPage']);
    exit;
}

// Retrieve the current phase from the settings table
$get_phase_sql = "SELECT setting_value FROM settings WHERE setting_name = 'phase'";
$get_phase_result = $conn->query($get_phase_sql);

if ($get_phase_result->num_rows > 0) {
    $row = $get_phase_result->fetch_assoc();
    $current_phase = intval($row['setting_value']);
}

// Perform database queries
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

?>

<!-- HTML markup -->
<h3 style="text-align: center">Votre demande d'internat précédente:</h3>

<?php if ($result->num_rows > 0) : ?>
    <div class="RoomList">
        <table id="data-table">
            <tr>
                <th>Numéro de la demande</th>
                <th>Date de soumission</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id_demande'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td style="text-transform: capitalize"><?= $row['status'] ?></td>
                    <td>
                        <?php if ($row['status'] == 'En attente') : ?>
                            <a class="reject" href="annuler_demande_internat.php?request_id=<?= $row['id_demande'] ?>&amp;name=<?= urlencode($row['name']) ?>">Annuler demande</a>
                        <?php else : ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php while ($row = $data->fetch_assoc()) : ?>
        <div class="discharge-container">
            <?php if ($current_phase != 1) : ?>
                <button class="discharge-button" onclick="redirect()">Télécharger Attestation<i class="icon fa fa-file-pdf"></i></button>

            <?php else : ?>
                <h5 style="text-align: center; color: red; font-weight: 800">Le téléchargement de votre attestation sera prochainement accessible au cours de la phase dédiée aux étudiants résidant à Casablanca.</h5>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>

<?php else : ?>
    <h5 style="text-align: center">Vous n'avez pas encore soumis de demandes d'internat.</h5> <br>
    <form class="discharge-container" action="../includes/demanderChambre.php" method="post">
        <button class="discharge-button" type="submit" name="create_request">Créer une demande</button>
    </form>
<?php endif; ?>

<?php
// Close statements and database connection
$selectStmt->close();
$conn->close();
?>

<script>
    function redirect() {
        window.location.href = '../includes/pdf.php';
    }
</script>