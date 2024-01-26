<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internat</title>
    <link rel="shortcut icon" href="images/ESTC.png" type="image/x-icon">
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/navbar.js"></script>
</head>

<body id="body-pd">
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="error-message" onclick="this.remove()"><?php echo $_SESSION['error'];
                                                            unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])) : ?>
        <div class="success-message" onclick="this.remove()"><?php echo $_SESSION['success'];
                                                                unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <header id="header" class="header fixed-top">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_txt">
            <h5>Validation de décharge - Administration </h5>
        </div>
        <div class="action">
            <div class="profile" onmouseover="menuToggle(true);" onmouseout="menuToggle(false);">
                <img src="images/default_user.png" />
            </div>
            <div class="menu" onmouseover="menuToggle(true);" onmouseout="menuToggle(false);">
                <h3>Lorem Ipsum<br /><span>Bouragba</span></h3>
                <ul>
                    <li>
                        <img src="images/user.png" /><a href="#">Mon Profile</a>
                    </li>
                    <li>
                        <img src="images/edit.png" /><a href="#">Modifier Profile</a>
                    </li>
                    <li>
                        <img src="images/envelope.png" /><a href="#">Inbox</a>
                    </li>
                    <li>
                        <img src="images/question.png" /><a href="#">Aide</a>
                    </li>
                    <li>
                        <img src="images/log-out.png" /><a href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        <script>
            function menuToggle(isHovered) {
                const toggleMenu = document.querySelector(".menu");
                const toggleProfile = document.querySelector(".profile");

                if (isHovered) {
                    toggleMenu.classList.add("active");
                    toggleProfile.classList.add("active");
                } else {
                    toggleMenu.classList.remove("active");
                    toggleProfile.classList.remove("active");
                }
            }
        </script>

        <div class="left">

        </div>
    </header>

    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> <a href="#" class="nav_logo"> <img src="images/ESTC.png" style="height:30px"><span class="nav_logo-name">Salam</span> </a>
                <div class="nav_list">
                    <a href="index.php" class="nav_link active">
                        <i class="fas fa-hotel"></i> <span class="nav_name">Map</span>
                    </a>
                    <a href="roomList.php" class="nav_link">
                        <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span>
                    </a>
                    <a href="department_decharge.php" class="nav_link">
                        <i class="fa fa-copy"></i> <span class="nav_name">Gestion décharge</span>
                    </a>
                </div>
            </div> <a href=""> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>

    <h2 style="text-align: center; margin-top:6rem">Demandes de décharge</h2>

    <hr>

    <div> <?php
            include 'db_connect.php';

            // Retrieve pending requests from the database (adjust the SQL query based on your schema)
            $sql = "SELECT decharge.*, students.*
FROM decharge
JOIN students ON decharge.student_id = students.id
WHERE decharge.status = 'pending' AND decharge.valide_departement = 1 AND decharge.valide_internat = 1 AND decharge.valide_economique = 1 AND decharge.valide_administration = 0;
";
            $result = $conn->query($sql);

            // Display requests in a table
            echo "<div class='RoomList'>";
            echo "<table id='data-table'>";
            echo '<thead><tr><th>Numéro de requete</th><th>Nom de l\'étudiant</th><th>Status</th>';
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo $row['status'] === 'interne' ? '<th>N° chambre</th>' : '';
            }
            echo '<th>Filière</th><th>Date de création</th><th>Action</th></tr></thead>';
            echo '<tbody>';

            // Reset the result pointer to the beginning of the result set
            $result->data_seek(0);

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id_demande'] . '</td>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo $row['status'] === 'interne' ? '<td>' . $row['room_number'] . '</td>' : '';
                echo '<td>' . $row['filliere'] . '</td>';
                echo '<td>' . $row['created_at'] . '</td>';
                // Action button to validate the request
                echo '<td><a href="administration_validation.php?request_id=' . $row['id_demande'] . '&amp;name=' . urlencode($row['name']) . '">Validate</a></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';


            echo '</tbody></table>';
            ?>
</body>

</html>