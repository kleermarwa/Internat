<?php
session_start();
include '../includes/db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    $sql = "SELECT *
            FROM users
            WHERE users.id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image = htmlspecialchars($row['image']);
        $CIN = htmlspecialchars($row['cin']);
        $name = htmlspecialchars($row['name']);
        $filliere = htmlspecialchars($row['filliere']);

        // Output HTML content
        echo "<div style='display:flex;background:whitesmoke;width: 650px;'>";
        echo "<img class='image' style='width: 200px; height: 200px' src='" . $image . "' alt=''>";
        echo "<div style='margin-left: 2rem; align-self: center;'>";
        echo "<p><b> Nom :</b> $name</p>";
        echo "<p><b>Cin : </b>$CIN</p>";
        echo "<p><b>Fillère : </b>$filliere </p>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "No user found with ID: $id";
    }

    $stmt->close();
} else {
    echo "Invalid user ID";
}
