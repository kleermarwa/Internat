<?php
session_start();
include '../includes/db_connect.php';
include '../includes/count.php';

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
    $output .= "<thead><tr><th>Numéro de demande</th><th>Nom de l'étudiant</th><th>Sexe</th><th>Ville</th><th>Date de création</th><th>Numéro de chambre</th><th>Nombre d'étudiants dans la chambre</th><th>Nombre de demandes pour la chambre</th><th colspan=2>Action</th></tr></thead>";
    $output .= "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $numStudentsInRoom = getNumberOfStudentsInRoom($conn, $row['room_alias'], $row['genre']);
        $numRequestsInRoom = getNumberOfRequestsInRoom($conn, $row['room_alias'], $row['genre']);
        $output .= "<tr>";
        $output .= "<td>" . $row['id_demande'] . "</td>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<td>" . ($row['genre'] == 'boy' ? 'Garçon' : 'Fille') . "</td>";

        $output .= "<td>" . $row['ville'] . "</td>";
        $output .= "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";
        $output .= "<td>" . $row['room_alias'] . "</td>";
        $output .= "<td style='font-weight:bold;" . ($numStudentsInRoom == 4 ? 'color:red;' : 'color:green;') . "'>" . $numStudentsInRoom . "</td>";
        $output .= "<td>" . $numRequestsInRoom . "</td>";
        if (strpos($previous_page, 'internat_demandes_valide.php') !== false) {

            $output .= "<td><button " . ($numStudentsInRoom == 4 ? "disabled" : "") . " class='add-student blue' data-id='" . $row['id_demande'] . "' data-room-alias='" . $row['room_alias'] . "' data-student-id='" . $row['id'] . "' data-genre='" . $row['genre'] . "' title='" . ($numStudentsInRoom == 4 ? "Impossible dֻe rajouter des étudiants additionnels à cette chambre" : '') . "' style='cursor: " . ($numStudentsInRoom == 4 ? 'not-allowed' : 'pointer') . "'>Ajouter chambre</button></td>";

            $output .= "<td><button style='font-size:0.8rem' class='cancel-validation reject' data-id='" . $row['id_demande'] . "'>Annuler validation</button></td>";
        } elseif (strpos($previous_page, 'internat_demandes_refuse.php') !== false) {
            $output .= "<td><button style='margin: 0 auto 0 auto;' class='validate-request validate' data-id='" . $row['id_demande'] . "''>Valider</button></td>";
        }
        $output .= "</tr>";
    }

    $output .= "</tbody>";
    $output .= "</table>";
    $output .= "</div>";

    echo $output;
} else {
    echo "Il n'y a aucune demande ";
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
            notificationElement.addClass('success-message')
            notificationElement.text(message);

            // Add a CSS class based on whether it's an error
            if (isError) {
                notificationElement.removeClass('success-message');
                notificationElement.addClass('error-message');
            }

            // Show the notification
            notificationElement.fadeIn();

            // Set a timeout to hide the notification after a certain duration
            setTimeout(function() {
                notificationElement.fadeOut();
            }, 2000);
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

            performAjaxRequest('../includes/moveStudent.php', data, 'L\'élève ' + idDemande + ' à été ajouté à l\'internat avec succès.');
        });

        // Click event for the "Annuler validation" button
        $('.cancel-validation').on('click', function() {
            var idDemande = $(this).data('id');
            var data = {
                id: idDemande
            };
            performAjaxRequest('../students/annuler_demande_internat.php', data, 'La validation de la demande ' + idDemande + ' a été annulée avec succes');
        });

        // Click event for the "Valider" button
        $('.validate-request').on('click', function() {
            var idDemande = $(this).data('id');
            var data = {
                id: idDemande
            };
            performAjaxRequest('../admin/internat_demandes_validation.php', data, 'La demande ' + idDemande + ' a été validée avec succes');
        });
    });
</script>