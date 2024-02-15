x²<?php
    session_start();
    include '../includes/db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get data from the AJAX request
        $id = $_POST["id"];
        $action = $_POST["action"]; // Retrieve the "action" parameter

        // Modify the SQL query based on the action parameter
        switch ($action) {
            case 'retourner':
                $sql = "UPDATE degats SET report='Retourné' WHERE id='$id';";
                break;
            case 'payer':
                $sql = "UPDATE degats SET report='Payé' WHERE id='$id';";
                break;

            default:
                echo "Invalid action parameter.";
                exit;
        }

        // Execute the SQL query
        if ($conn->query($sql) === TRUE) {
            echo "Action performed successfully!";
        } else {
            echo "Error performing action: " . $conn->error;
        }
    } else {
        echo "Error: This page cannot be accessed directly.";
    }
    ?>