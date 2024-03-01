<?php
session_start();
include '../includes/db_connect.php';
include '../includes/count.php';

// Get the URL of the previous page
$previous_page = $_SERVER['HTTP_REFERER'];
$action = $_GET["action"];

$sql = "SELECT internat.*, users.*
        FROM internat
        JOIN users ON internat.student_id = users.id ";

if (strpos($previous_page, 'internat_demandes_valide.php') !== false) {
    $sql .= "WHERE internat.valide = 1 AND internat.status = 'En attente'";
} elseif (strpos($previous_page, 'internat_demandes_refuse.php') !== false) {
    $sql .= "WHERE internat.status = 'Refusé'";
}
if ($action == 'search') {
    $searchInput = $conn->real_escape_string($_GET['input']);
    $sql .= " AND ((users.name LIKE '%$searchInput%') OR (internat.id_demande LIKE '%$searchInput%'))";
}
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $output = "<div class='RoomList'>";
    $output .= "<table id='data-table'>";
    $output .= "<thead><tr><th>Numéro de demande</th><th>Nom de l'étudiant</th><th>Sexe</th><th>Ville</th><th>Date de création</th><th>Action</th></tr></thead>";
    $output .= "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row['id_demande'] . "</td>";
        $output .= "<td>" . $row['name'] . "</td>";
        $output .= "<td>" . ($row['genre'] == 'boy' ? 'Garçon' : 'Fille') . "</td>";

        $output .= "<td>" . (($row['ville'] != NULL) ? $row['ville'] : $row['pays'])  . "</td>";
        $output .= "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";
        if (strpos($previous_page, 'internat_demandes_valide.php') !== false) {

            $output .= "<td><button class='add-student blue' data-name='" . $row['name'] . "' data-id='" . $row['id_demande'] . "' data-student-id='" . $row['id'] . "' data-genre='" . $row['genre'] . "'>Ajouter chambre</button>";
            if ($row['ville'] == 'Casablanca') {
                $output .= "<button style='font-size:0.8rem ; margin-top: 1rem' class='cancel-validation reject' data-id='" . $row['id_demande'] . "'>Annuler validation</button></td>";
            } else {
                $output .= "</td>";
            }
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
            var genre = $(this).data('genre');
            var idDemande = $(this).data('id');
            var studentId = $(this).data('student-id');
            var name = $(this).data('name');

            // Replace prompt with AJAX request to get the next available room
            $.ajax({
                url: '../includes/getNextAvailableRoom.php',
                type: 'GET',
                data: {
                    genre: genre
                },
                success: function(response) {
                    if (response !== 'No available rooms') {
                        const nextAvailableRoom = parseInt(response);

                        var data = {
                            id: idDemande,
                            studentId: studentId,
                            genre: genre,
                            newRoomNumber: nextAvailableRoom
                        };
                        var confirmMessage = 'L\'étudiant ' + name + ' ayant la demande ' + idDemande + ' sera ajouté à la chambre ' + nextAvailableRoom;

                        // Use the next available room for the student
                        if (confirm(confirmMessage)) {
                            performAjaxRequest('../includes/moveStudent.php', data, 'L\'étudiant ' + name + ' à été ajouté à la chambre +' + nextAvailableRoom + ' avec succès.');
                        }
                    } else {
                        // Handle the case where no available rooms are found
                        displayNotification('Aucune chambre disponible pour le genre spécifié.', true);
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                    // Display an error notification if needed
                    displayNotification('An error occurred.', true);
                }
            });
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