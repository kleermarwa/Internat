<?php
session_start();
include '../includes/db_connect.php';

if (isset($_SESSION['filliere'])) {
    if (isset($_GET['input']) && !empty($_GET['input'])) {
        $searchInput = $conn->real_escape_string($_GET['input']);
        $sql = "SELECT users.*, degats.*, users.cin AS student_cin , degats.id AS degats_id
    FROM users
    LEFT JOIN degats ON users.id = degats.user_id
    WHERE filliere='" . $_SESSION["filliere"] . "'
    AND users.name LIKE '%$searchInput%'";
    }
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $output = "<div class='RoomList'>";
    $output .= "<table id='data-table'>";
    $output .= "<thead><tr><th>Nom de l'étudiant</th><th>Matériel</th><th>Montant</th><th>Type</th><th>Commentaire</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>";
    $output .= "<tbody>";

    $rowIndex = 0; // Add a variable to keep track of the row index

    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<input type='hidden' id='id" . $rowIndex . "' name='id' value='" . $row['degats_id'] . "'>";
        $output .= "<td>" . (($row['materiel'] === NULL || $row['materiel'] === '') ? '-' : $row['materiel']) . "</td>";
        $output .= "<td>" . (($row['montant'] === NULL || $row['montant'] === '') ? '-' : $row['montant'] . " DH") . "</td>";
        $output .= "<td>" . (($row['type'] === NULL || $row['type'] === '') ? '-' : $row['type']) . "</td>";
        $output .= "<td>" . (($row['commentaire'] === NULL || $row['commentaire'] === '') ? '-' : $row['commentaire']) . "</td>";
        $output .= "<td>" . (($row['report'] === NULL || $row['report'] === '') ? '-' : $row['report']) . "</td>";
        $output .= "<td>" . (($row['date'] === NULL || $row['date'] === '') ? '-' : date('d-m-Y', strtotime($row['date']))) . "</td>";


        $output .= ($row['report'] === 'Non Payé' || $row['report'] === 'Non Retourné') ?
            (($row['type'] === 'Incident') ?
                "<td><a class='blue' href='javascript:void(0)' onclick='showInputs(\"" . $row['student_cin'] . "\", " . $rowIndex . ")'>Ajouter</a><a class='validate' href='javascript:void(0)' onclick='payer(" . $rowIndex . ")'>Payer</a></td>"
                : "<td><a class='blue' href='javascript:void(0)' onclick='showInputs(\"" . $row['student_cin'] . "\", " . $rowIndex . ")'>Ajouter</a><a class='reject' href='javascript:void(0)' onclick='retourner(" . $rowIndex . ")'>Retourner</a></td>"
            )
            : "<td><a class='blue' href='javascript:void(0)' onclick='showInputs(\"" . $row['student_cin'] . "\", " . $rowIndex . ")'>Ajouter</a></td>"; // Adjust this line as per your requirement


        $output .= "</tr>";

        // Additional hidden row with inputs
        $output .= "<tr id='inputRow" . $rowIndex . "' style='display:none;'>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<input type='hidden' id='cin" . $rowIndex . "' name='cin' value='" . $row['student_cin'] . "'>";
        $output .= "<td><input type='text' id='materiel" . $rowIndex . "' name='materiel' placeholder='Materiel'></td>";
        $output .= "<td><input type='text' id='montant" . $rowIndex . "' name='montant' placeholder='Montant'></td>";
        $output .= "<td>
    <select id='type" . $rowIndex . "' name='type'>
        <option value='Incident'>Incident</option>
        <option value='Emprunt'>Emprunt</option>
    </select>
</td>";
        $output .= "<td><input type='text' id='commentaire" . $rowIndex . "' name='commentaire' placeholder='Commentaire'></td>";
        $output .= "<td></td>";
        $output .= "<td></td>";
        $output .= "<td><button class='validate' onclick='submitForm(\"" . $row['student_cin'] . "\", " . $rowIndex . ")'>Valider</button>";
        $output .= "<button class='reject' onclick='cancel(\"" . $row['student_cin'] . "\", " . $rowIndex . ")'>Annuler</button></td>";
        $output .= "</tr>";

        $rowIndex++;
    }

    $output .= "</tbody>";
    $output .= "</table>";
    $output .= "</div>";

    echo $output;
} else {
    echo "Il n'y a aucune demande ";
}
?>

<script>
    function showInputs(cin, rowIndex) {
        var inputRow = document.getElementById("inputRow" + rowIndex);
        inputRow.style.display = "table-row";
        console.log(cin)
    }

    function cancel(cin, rowIndex) {
        var inputRow = document.getElementById("inputRow" + rowIndex);
        inputRow.style.display = "none";
    }

    function submitForm(cin, rowIndex) {
        var materiel = document.getElementById("materiel" + rowIndex).value;
        var montant = document.getElementById("montant" + rowIndex).value;
        var commentaire = document.getElementById("commentaire" + rowIndex).value;
        var type = document.getElementById("type" + rowIndex).value; // Retrieve the selected 'type'
        // var cin = document.getElementById("cin" + rowIndex).value;

        $.ajax({
            type: "POST",
            url: "degatsAjout.php",
            data: {
                cin: cin,
                materiel: materiel,
                montant: montant,
                commentaire: commentaire,
                type: type
            },
            success: function(response) {
                // Handle the response from the server
                console.log(response);
                loadAllResults();
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed: " + error);
            },
        });
    }

    function payer(rowIndex) {
        var id = document.getElementById("id" + rowIndex).value;

        // Display a confirmation dialog
        var isConfirmed = confirm("Confirmez-vous le paiement ?");

        if (isConfirmed) {
            $.ajax({
                type: "POST",
                url: "degatsReport.php",
                data: {
                    id: id,
                    action: "payer",
                },
                success: function(response) {
                    console.log(response);
                    loadAllResults();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed: " + error);
                },
            });
        }
    }

    function retourner(rowIndex) {
        var id = document.getElementById("id" + rowIndex).value;

        // Display a confirmation dialog
        var isConfirmed = confirm("Confirmez-vous le retour du materiel ?");

        if (isConfirmed) {
            $.ajax({
                type: "POST",
                url: "degatsReport.php",
                data: {
                    id: id,
                    action: "retourner",
                },
                success: function(response) {
                    // Handle the response from the server
                    console.log(response);
                    loadAllResults(); // Assuming you have a function to reload the results
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed: " + error);
                },
            });
        }
    }
</script>