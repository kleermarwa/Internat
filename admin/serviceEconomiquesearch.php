<?php
session_start();
include '../includes/db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    $sql = "SELECT paiements.*, users.*
    FROM paiements
    JOIN users ON paiements.user_id = users.id 
    WHERE users.id = $id ";

    $result = $conn->query($sql);

    $data = $conn->query("SELECT * FROM users WHERE id='$id'");

    if ($data->num_rows == 1) {
        $row = $data->fetch_assoc();
        $image = $row['image'];
        $CIN = $row['cin'];
        $name = $row['name'];
        $filliere = $row['filliere'];
    }

    // Display the table header
    echo "<table border='1'>
                <tr>
                    <th>Trimestre 1</th>
                    <th>Trimestre 2</th>
                    <th>Trimestre 3</th>
                </tr>";

    // Initialize arrays to track paid status, montant, date, and recu for each trimester
    $trimesterData = array(
        1 => ['paid' => false, 'payé' => 0, 'montant' => 1050, 'date' => '', 'recu' => ''],
        2 => ['paid' => false, 'payé' => 0, 'montant' => 850, 'date' => '', 'recu' => ''],
        3 => ['paid' => false, 'payé' => 0, 'montant' => 850, 'date' => '', 'recu' => '']
    );

    // Iterate through the result set
    while ($row = $result->fetch_assoc()) {
        $trimester = $row['trimestre'];
        $payé = $row['montant'];
        $date = $row['date_paiement'];
        $recu = $row['recu'];

        // Update the paid status, montant, date, and recu for the current row's trimester
        $trimesterData[$trimester]['paid'] = true;
        $trimesterData[$trimester]['payé'] = $payé;
        $trimesterData[$trimester]['date'] = $date;
        $trimesterData[$trimester]['recu'] = $recu;
    }
    echo "<div style='display:flex;justify-content: center;'>";
    echo "<img class='image' style='width: 200px; height: 200px' src='" . $image . "' alt=''>";
    echo "<div style='margin-left: 2rem; align-self: center;'>";
    echo "<p> Nom : $name </p>";
    echo "<p>Cin : $CIN </p>";
    echo "<p>Fillère : $filliere </p>";
    echo "</div>";
    echo "</div>";
    // Display the table rows based on paid status, montant, date, and recu
    echo "<tr>";
    foreach ($trimesterData as $trimester => $data) {
        $montant = $data['montant'];
        echo "<td>";
        if ($data['paid']) {
            echo "<p style='font-weight: bold; color:green'>Payé</p> ";
            echo "Montant payé : <span style='font-weight: bold; color:blue'> {$data['payé']} DH </span><br>";
            echo "Date de paiement : {$data['date']}<br>";
            echo "Numéro de reçu : {$data['recu']}<br>";
            echo "<button class='reject' style='margin-top: 2rem;' onclick='cancel($id, $trimester)'>Annuler Paiement</button>";
        } else {
            // Add the input for "numéro de reçu"
            echo "<input class='input1' type='text' name='num_recu' id='num_recu' placeholder='Numéro de reçu' required>";
            echo "<button class='validate' onclick='payAll($id, $trimester, $montant)'>Payer tout</button>";

            // Add the input for the specific amount and button
            echo "<br>";
            echo "<input class='input2' type='number' name='specific_amount' id='specific_amount' placeholder='Montant spécifique'>";
            echo "<button class='blue' onclick='paySpecific($id, $trimester)'>Payer spécifique</button>";
        }
        echo "</td>";
    }
    echo "</tr>";

    // Close the table
    echo "</table>";
} else {
    echo "Invalid input.";
}

// Close the database connection
$conn->close();
?>
<script>
    function payAll(id, trimester, montant) {
        // You may want to confirm the payment or perform additional checks before proceeding
        var numRecu = document.getElementById('num_recu').value;
        if (numRecu.trim() === '') {
            alert("Veuillez saisir le Numéro de Reçu avant de passer au paiement.");
            return;
        }

        var confirmPayment = confirm("Êtes-vous sûr de vouloir valider le paiement de " + montant + " dh pour tout le trimestre?");

        if (confirmPayment) {
            // Perform AJAX request to process the payment
            $.ajax({
                type: "POST",
                url: "process_payment.php", // Replace with the actual processing script
                data: {
                    montant: montant,
                    trimester: trimester,
                    id: id,
                    num_recu: numRecu // Pass the numéro de reçu in the data
                },
                dataType: "json", // Expect JSON response
                success: function(response) {
                    if (response.success) {
                        // Update the UI or handle success as needed
                        showSuccessMessage("Paiement réussi!");
                        loadPayment(id);
                    } else {
                        // Handle payment failure
                        alert("Erreur de paiement: " + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", xhr.responseText);
                    // Handle errors or display an appropriate message to the user
                }

            });
        }
    }

    function paySpecific(id, trimester) {
        // You may want to confirm the payment or perform additional checks before proceeding
        var numRecu = document.getElementById('num_recu').value;
        if (numRecu.trim() === '') {
            alert("Veuillez saisir le Numéro de Reçu avant de passer au paiement.");
            return;
        }
        var montant = document.getElementById('specific_amount').value;
        if (montant.trim() === '' || isNaN(montant) || montant <= 0) {
            alert("Veuillez saisir un montant spécifique valide avant de passer au paiement.");
            return;
        }

        var confirmPayment = confirm("Êtes-vous sûr de souhaiter valider le paiement de " + montant + " dh pour le trimestre?");

        if (confirmPayment) {
            // Perform AJAX request to process the specific amount payment
            $.ajax({
                type: "POST",
                url: "process_payment.php", // Replace with the actual processing script for specific amount
                data: {
                    montant: montant,
                    trimester: trimester,
                    id: id,
                    num_recu: numRecu // Pass the numéro de reçu in the data
                },
                dataType: "json", // Expect JSON response
                success: function(response) {
                    if (response.success) {
                        // Update the UI or handle success as needed
                        showSuccessMessage("Paiement de montant spécifique réussi!");
                        loadPayment(id);
                    } else {
                        // Handle payment failure
                        alert("Erreur de paiement: " + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", xhr.responseText);
                    // Handle errors or display an appropriate message to the user
                }
            });
        }
    }

    function cancel(id, trimester) {
        var confirmCancel = confirm("Êtes-vous sûr de vouloir annuler");

        if (confirmCancel) {
            // Perform AJAX request to process the cancellation
            $.ajax({
                type: "POST",
                url: "cancel_payment.php",
                data: {
                    trimester: trimester,
                    id: id,
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        // Cancellation successful
                        showSuccessMessage(result.message);
                        loadPayment(id);
                    } else {
                        // Cancellation failed
                        alert("Annulation échouée: " + result.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed: " + error);
                    // Handle errors or display an appropriate message to the user
                }
            });
        }
    }

    function showSuccessMessage(message) {
        $('<div class="success">' + message + '</div>').appendTo('body').fadeIn(300).delay(3000).fadeOut(400);
    }

    function showErrorMessage(message) {
        $('<div class="error">' + message + '</div>').appendTo('body').fadeIn(300).delay(3000).fadeOut(400);
    }
</script>