<?php
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'student' ?  null :  header("Location:" . $_SESSION['defaultPage']);

$selectQuery = "SELECT decharge.*, users.*, users.status AS student_status, decharge.status AS decharge_status
                FROM decharge 
                JOIN users ON decharge.student_id = users.id 
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
    echo "<tr><th>Numéro de la demande</th><th>Date de soumission</th><th>Validé département</th><th>Validé internat</th><th>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {

        // Check if there are records in the degats table for the student
        $degatsQuery = "SELECT * FROM degats WHERE user_id = ?";
        $degatsStmt = $conn->prepare($degatsQuery);
        $degatsStmt->bind_param('i', $user_id);
        $degatsStmt->execute();
        $degatsResult = $degatsStmt->get_result();

        $status = $row['decharge_status'];
        $student_status = $row['student_status'];
        $creationDate = new DateTime($row['created_at']);
        // $creationDate = new DateTime('2024-03-01');
        // $januaryFirst = new DateTime('2024-01-01');
        // $creationDate = new DateTime(date('Y') . '-06-30');
        $januaryFirst = new DateTime(date('Y') . '-01-01');
        $diff = $creationDate->diff($januaryFirst);
        $days = $diff->days + 1;

        $halfMonths = 0;
        $tirage = 100;

        // Check conditions for each half month
        if ($days >= 1 && $days <= 15) {
            $halfMonths = 1;
        } elseif ($days >= 16 && $days <= 31) {
            $halfMonths = 2;
        } elseif ($days >= 32 && $days <= 46) {
            $halfMonths = 3;
        } elseif ($days >= 47 && $days <= 59) {
            $halfMonths = 4;
        } elseif ($days >= 60 && $days <= 74) {
            $halfMonths = 5;
        } elseif ($days >= 77 && $days <= 90) {
            $halfMonths = 6;
        } elseif ($days >= 91 && $days <= 105) {
            $halfMonths = 7;
            $tirage += 100;
        } elseif ($days >= 106 && $days <= 120) {
            $halfMonths = 8;
            $tirage += 100;
        } elseif ($days >= 121 && $days <= 135) {
            $halfMonths = 9;
            $tirage += 100;
        } elseif ($days >= 136 && $days <= 151) {
            $halfMonths = 10;
            $tirage += 100;
        } elseif ($days >= 152 && $days <= 166) {
            $halfMonths = 11;
            $tirage += 100;
        } elseif ($days >= 167 && $days <= 181) {
            $halfMonths = 12;
            $tirage += 100;
        }

        $currentYear = date('Y');
        $isLeapYear = (date('L', strtotime("{$currentYear}-01-01")) == 1);

        if ($isLeapYear) {
            // Check conditions for each half month
            if ($days >= 1 && $days <= 15) {
                $halfMonths = 1;
            } elseif ($days >= 16 && $days <= 31) {
                $halfMonths = 2;
            } elseif ($days >= 32 && $days <= 46) {
                $halfMonths = 3;
            } elseif ($days >= 47 && $days <= 60) {
                $halfMonths = 4;
            } elseif ($days >= 61 && $days <= 75) {
                $halfMonths = 5;
            } elseif ($days >= 76 && $days <= 91) {
                $halfMonths = 6;
            } elseif ($days >= 92 && $days <= 106) {
                $halfMonths = 7;
                $tirage += 100;
            } elseif ($days >= 107 && $days <= 121) {
                $halfMonths = 8;
                $tirage += 100;
            } elseif ($days >= 122 && $days <= 136) {
                $halfMonths = 9;
                $tirage += 100;
            } elseif ($days >= 137 && $days <= 152) {
                $halfMonths = 10;
                $tirage += 100;
            } elseif ($days >= 153 && $days <= 167) {
                $halfMonths = 11;
                $tirage += 100;
            } elseif ($days >= 168 && $days <= 182) {
                $halfMonths = 12;
                $tirage += 100;
            }
        }

        // Now you can use $halfMonths as needed
        $accommodationFee = $halfMonths * 50;
        $restaurationFee = $halfMonths * 75;

        // echo "Half Months: $halfMonths";
        // echo "Accommodation Fee: $accommodationFee";
        // echo "Restauration Fee: $restaurationFee";

        if ($row['student_status'] == 'interne') {
            $totalFee = $accommodationFee + $restaurationFee + $tirage;
            if ($totalFee > 850) {
                $trimestre2 = 850;
                $trimestre3 = $totalFee - 850;
            } else {
                $trimestre2 = $totalFee;
                $trimestre3 = 0;
            }
        } elseif ($row['student_status'] == 'externe') {
            $totalFee = 300;
        }
        // Check if there are records in the paiement table for the student
        $paye2 = 'Non payé';
        $paye3 = 'Non payé';
        $paiement2Query = "SELECT * FROM paiements WHERE user_id = ? AND trimestre = 2 ";
        $paiement2Stmt = $conn->prepare($paiement2Query);
        $paiement2Stmt->bind_param('i', $user_id);
        $paiement2Stmt->execute();
        $paiement2Result = $paiement2Stmt->get_result();

        if ($paiement2Result->num_rows > 0) {
            // If there is a record in the paiement table, substitute the montant from the totalFee
            $paiementRow = $paiement2Result->fetch_assoc();
            $totalFee -= $paiementRow['montant'];
            $paye2 = 'Payé';
        }
        // Check if there are records in the paiement table for the student
        $paiement3Query = "SELECT * FROM paiements WHERE user_id = ? AND trimestre = 3 ";
        $paiement3Stmt = $conn->prepare($paiement3Query);
        $paiement3Stmt->bind_param('i', $user_id);
        $paiement3Stmt->execute();
        $paiement3Result = $paiement3Stmt->get_result();

        if ($paiement3Result->num_rows > 0) {
            // If there is a record in the paiement table, substitute the montant from the totalFee
            $paiementRow = $paiement3Result->fetch_assoc();
            $totalFee -= $paiementRow['montant'];
            echo $paiementRow['montant'];
            $paye3 = 'Payé';
        }

        $dep = $row['valide_departement'];
        $int = $row['valide_internat'];
        echo "<tr style='text-align-last :center'>";
        echo "<td>" . $row['id_demande'] . "</td>";
        echo "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['valide_departement'] ? 'green' : 'red') . "'>" . ($row['valide_departement'] ? '✔<br>Oui' : '❌<br>Non ') . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['valide_internat'] ? 'green' : 'red') . "'>" . ($row['valide_internat'] ? '✔<br>Oui' : '❌<br>Non ') . "</td>";
        echo "<td style='font-weight:800 ;color: " . ($row['decharge_status'] == 'En attente' ? 'blue' : 'green') . "'>" . $row['decharge_status'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    if ($dep == 1 and $int == 1) {
        echo '<div style="text-align:center">';
        echo "<p>Jour : $days</p>";
        if ($degatsResult->num_rows > 0) {

            echo "<h6 style='text-align: center'>Détails des dégâts: </h6>";

            while ($degatsRow = $degatsResult->fetch_assoc()) {
                echo "<h6 style='text-align: center'>" . date('d-m-Y', strtotime($degatsRow['date'])) . " - " . $degatsRow['materiel']  . " - Montant: " . $degatsRow['montant'] . " dh : " . $degatsRow['report'] . "</h6>";
                if ($degatsRow['report'] == 'Non Payé' || $degatsRow['report'] == 'Non Retourné') {
                    $totalFee += $degatsRow['montant'];
                }
            }
        }
        echo "<h6>Trimestre 2 : $trimestre2 dh : $paye2</h6>";
        echo "<h6>Trimestre 3 : $trimestre3 dh : $paye3</h6><br>";
        echo "<h5 style='color:green;font-weight:800'>Total à payer : $totalFee dh</h5>";
        echo '<h6 style="font-weight:600;text-align:center">Cette attestation doit être imprimée et rendue au service économique pour finaliser la décharge</h6>';
        if ($student_status == 'interne') {
            echo '<p style="text-align:center; font-weight:800 ;color:red"> Il est impératif de régler ce montant lors du retour de ce document pour compléter intégralement la décharge, le montant étant calculé jusqu\'au jour de la soumission de la demande.</p>';
        } elseif ($student_status == 'externe') {
            echo '<p style="text-align:center; font-weight:800 ;color:red"> Il est impératif de régler ce montant pour les étudiants externes lors du retour de ce document pour compléter intégralement la décharge</p>';
        }
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