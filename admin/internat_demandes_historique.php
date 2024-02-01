<?php
session_start();
include '../includes/db_connect.php';

// Get the URL of the previous page
$previous_page = $_SERVER['HTTP_REFERER'];

$sql = "SELECT internat.*, students.*, internat.room_number AS room_alias
        FROM internat
        JOIN students ON internat.student_id = students.id ";

if (strpos($previous_page, 'internat_demandes_valide.php') !== false) {
    $sql .= "WHERE internat.status = 'Accepté'";
} elseif (strpos($previous_page, 'internat_demandes_refuse.php') !== false) {
    $sql .= "WHERE internat.status = 'Refusé'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $output = "<div class='RoomList'>";
    $output .= "<table id='data-table'>";
    $output .= "<thead><tr><th>Numéro de requete</th><th>Nom de l'étudiant</th><th>Ville</th><th>Filière</th><th>Date de mise à jour</th><th colspan=2>Action</th></tr></thead>";
    $output .= "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row['id_demande'] . "</td>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<td>" . $row['ville'] . "</td>";
        $output .= "<td>" . $row['filliere'] . "</td>";
        $output .= "<td>" . $date = date('d-m-Y', strtotime($row['updated_at'])) . "</td>";
        if (strpos($previous_page, 'internat_demandes_valide.php') !== false) {
            $output .= "<td><button class='add-student blue' data-id='" . $row['id_demande'] . "' data-room-alias='" . $row['room_alias'] . "' data-student-id='" . $row['id'] . "' data-genre='" . $row['genre'] . "'>Ajouter chambre</button></td>";
            // Button to cancel validation
            $output .= "<td><button class='cancel-validation reject' data-id='" . $row['id_demande'] . "'>Annuler validation</button></td>";
        } elseif (strpos($previous_page, 'internat_demandes_refuse.php') !== false) {
            $output .= "<td><button class='validate-request validate' data-id='" . $row['id_demande'] . "''>Valider</button></td>";
        }
        $output .= "</tr>";
    }

    $output .= "</tbody>";
    $output .= "</table>";
    $output .= "</div>";

    echo $output;
} else {
    echo "No results found.";
}

$conn->close();
?>
<script>
    $(document).ready(function() {
        // Function to handle AJAX requests and display notifications
        function performAjaxRequest(url, data, successMessage) {
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    // Handle the response if needed
                    displayNotification(successMessage);
                },
                error: function(error) {
                    console.error('Error:', error);
                    // Display an error notification if needed
                    displayNotification('An error occurred.', true);
                }
            });
        }

        // Function to display notifications
        function displayNotification(message, isError = false) {
            var notificationElement = $('#notification');
            notificationElement.text(message);

            // Add a CSS class based on whether it's an error
            notificationElement.removeClass('error-notification');
            if (isError) {
                notificationElement.addClass('error-notification');
            }

            // Show the notification
            notificationElement.fadeIn();

            // Set a timeout to hide the notification after a certain duration
            setTimeout(function() {
                notificationElement.fadeOut();
            }, 3000); // Adjust the timeout duration (in milliseconds) as needed
        }

        // Click event for the "Ajouter chambre" button
        $('.add-student').on('click', function() {
            var idDemande = $(this).data('id');
            var roomAlias = $(this).data('room-alias');
            var studentId = $(this).data('student-id');
            var genre = $(this).data('genre');

            var data = {
                id: idDemande,
                newRoomNumber: roomAlias,
                studentId: studentId,
                genre: genre
            };

            performAjaxRequest('../includes/moveStudent.php', data, 'Student added successfully.');
        });

        // Click event for the "Annuler validation" button
        $('.cancel-validation').on('click', function() {
            var idDemande = $(this).data('id');
            var data = {
                id: idDemande
            };
            performAjaxRequest('../students/annuler_demande_internat.php', data, 'Validation canceled successfully.');
        });

        // Click event for the "Valider" button
        $('.validate-request').on('click', function() {
            var idDemande = $(this).data('id');
            var data = {
                id: idDemande
            };
            performAjaxRequest('../admin/internat_demandes_validation.php', data, 'Request validated successfully.');
        });
    });
</script>