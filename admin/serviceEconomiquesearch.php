<?php
session_start();
include '../includes/db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['input']) && !empty($_GET['input'])) {
    $searchInput = $conn->real_escape_string($_GET['input']);
    $sql = "SELECT * FROM paiements WHERE ((user_name LIKE '%$searchInput%') OR (recu LIKE '%$searchInput%')) ";

    $sql = "SELECT paiements.*, users.*
    FROM paiements
    JOIN users ON paiements.user_id = users.id 
    WHERE ((user_name LIKE '%$searchInput%') OR (recu LIKE '%$searchInput%'))";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the table header
        echo "<table border='1'>
                <tr>
                    <th>Trimestre 1</th>
                    <th>Trimestre 2</th>
                    <th>Trimestre 3</th>
                </tr>";

        // Initialize arrays to track paid status for each trimester
        $trimesterPaid = array(1 => false, 2 => false, 3 => false);

        // Iterate through the result set
        while ($row = $result->fetch_assoc()) {
            $trimester = $row['trimestre'];
            echo "<img style='width: 200px; height: 200px' src='" . $row['image'] . "' alt=''>";

            // Update the paid status for the current row's trimester
            $trimesterPaid[$trimester] = true;
        }

        // Display the table rows based on paid status
        echo "<tr>";
        foreach ($trimesterPaid as $paid) {
            echo "<td>";
            if ($paid) {
                echo "Paid";
            } else {
                echo "<button onclick='payFunction()'>Pay</button>";
            }
            echo "</td>";
        }
        echo "</tr>";

        // Close the table
        echo "</table>";
    } else {
        echo "No results found.";
    }
} else {
    echo "Invalid input.";
}

// Close the database connection
$conn->close();
