<?php
include 'db_connect.php';
include '../includes/count.php';

// Retrieve the current phase from the settings table
$get_phase_sql = "SELECT setting_value FROM settings WHERE setting_name = 'phase'";
$get_phase_result = $conn->query($get_phase_sql);

$current_phase = 1; // Default phase if not found or error occurs
if ($get_phase_result->num_rows > 0) {
    $row = $get_phase_result->fetch_assoc();
    $current_phase = intval($row['setting_value']);
}

// Display the list of requests or the button based on the current phase
if ($current_phase != 1) {
    // Phase 1: Display the list of requests
    $action = $_GET["action"];

    $sql = "SELECT internat.*, users.*
            FROM internat
            JOIN users ON internat.student_id = users.id
            WHERE users.ville =  'Casablanca'
            AND internat.status = 'En attente'
            AND internat.valide = 0";

    if ($action == 'search') {
        if (isset($_GET['input']) && !empty($_GET['input'])) {
            $searchInput = $conn->real_escape_string($_GET['input']);
            $sql .= " AND ((users.name LIKE '%$searchInput%') OR (internat.id_demande LIKE '%$searchInput%'))";
        }
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $output = "<div class='RoomList'>";
        $output .= "<div style='margin: 1rem;display: flex;justify-content: center';>";
        $output .= "<button class='reject' onclick='setPhaseTo1()'>Fermer phase</button>";
        $output .= "</div>";
        $output .= "<table id='data-table'>";
        $output .= "<thead><tr><th>Numéro de demande</th><th>Nom de l'étudiant</th><th>Sexe</th><th>Année</th><th>Date de création</th><th>Action</th></tr></thead>";
        $output .= "<tbody>";

        while ($row = $result->fetch_assoc()) {
            $output .= "<tr>";
            $output .= "<td>" . $row['id_demande'] . "</td>";
            $output .= "<td>" . $row['name'] . "</td>";
            $output .= "<td>" . ($row['genre'] == 'boy' ? 'Garçon' : 'Fille') . "</td>";
            $output .= "<td>" . $row['annee_scolaire'] . "</td>";
            $output .= "<td>" . $date = date('d-m-Y', strtotime($row['created_at'])) . "</td>";

            $output .= "<td><button class='add-student blue' data-name='" . $row['name'] . "' data-id='" . $row['id_demande'] . "' data-student-id='" . $row['id'] . "' data-genre='" . $row['genre'] . "'>Ajouter chambre</button>";
            if ($row['annee_scolaire'] != 1) {
                $output .= "<button style='font-size: 0.8rem; margin-top: 1rem;' class='validate' onclick='addStudent(" . $row['id_demande'] . ', ' . $row['id'] . ", \"" . $row['genre'] . "\")'>Choisir chambre</button>";
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
} else {
    // Phase is not 1: Display the button to set the phase to 2
    echo '<div style="margin-top: 5rem;display: flex;justify-content: center;" >';
    echo "<button class='blue' onclick='setPhaseTo2()'>Passer à la phase 2</button>";
    echo '</div>';
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

    });
</script>