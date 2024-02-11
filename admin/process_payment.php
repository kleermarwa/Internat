<?php
session_start();
include '../includes/db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming the payment_amount and trimester values are posted
    $trimester = $_POST['trimester'];
    $id = $_POST['id'];
    $montant = $_POST['montant'];
    $num_recu = $_POST['num_recu'];

    // Validate and sanitize the input values
    $trimester = filter_var($trimester, FILTER_VALIDATE_INT);
    $id = filter_var($id, FILTER_VALIDATE_INT);
    $montant = filter_var($montant, FILTER_VALIDATE_FLOAT);

    if ($trimester === false || $id === false || $montant === false) {
        // Invalid input values
        echo json_encode(['success' => false, 'error' => 'Invalid input values']);
        exit;
    }

    $result = $conn->prepare("SELECT name, cin FROM users WHERE id=?");
    $result->bind_param("i", $id);
    $result->execute();
    $result->store_result();

    if ($result->num_rows == 1) {
        $result->bind_result($name, $cin);
        $result->fetch();
    }

    // Check if the recu already exists in the database
    $existingRecuQuery = "SELECT * FROM paiements WHERE recu=?";
    $existingRecuStmt = $conn->prepare($existingRecuQuery);
    $existingRecuStmt->bind_param("s", $num_recu);
    $existingRecuStmt->execute();
    $existingRecuResult = $existingRecuStmt->get_result();

    if ($existingRecuResult->num_rows > 0) {
        // Recu already exists, show an error message
        echo json_encode(['success' => false, 'error' => 'Ce numéro de reçu existe déjà. Veuillez en utiliser un autre.']);
    } else {
        // Perform the payment processing logic using prepared statements
        $sql = "INSERT INTO paiements (recu, user_id, user_name, cin, trimestre, montant, date_paiement) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissdi", $num_recu, $id, $name, $cin, $trimester, $montant);

        if ($stmt->execute()) {
            // Payment successful
            echo json_encode(['success' => true, 'message' => 'Payment successful!']);
        } else {
            // Payment failed
            echo json_encode(['success' => false, 'error' => 'Erreur lors de traitement du paiement: ' . $stmt->error]);
        }

        $stmt->close();
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Méthode de demande non valide']);
}
