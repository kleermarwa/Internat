<?php
include '../includes/user_info.php';
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'internat' ?  null :  header("Location:" . $_SESSION['defaultPage']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internat</title>
    <link rel="shortcut icon" href="../images/ESTC.png" type="image/x-icon">
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/demandeInternatSearch.js"></script>
    <script src="../js/navbar.js"></script>
    
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
            <h5>Validation demande de chambre - Service des affaires d'internat </h5>
        </div>
        <div class="action">
            <div class="profile" onmouseover="menuToggle(true);" onmouseout="menuToggle(false);">
                <img src="<?php echo $image ?>" />
            </div>
            <div class="menu" onmouseover="menuToggle(true);" onmouseout="menuToggle(false);">
                <h3><?php echo $name ?></h3>
                <ul>
                    <li>
                        <img src="../images/user.png" /><a href="../includes/profile.php">Mon Profile</a>
                    </li>
                    <li>
                        <img src="../images/edit.png" /><a href="../includes/updateProfile.php">Modifier Profile</a>
                    </li>
                    <li>
                        <img src="../images/envelope.png" /><a href="#">Inbox</a>
                    </li>
                    <li>
                        <img src="../images/question.png" /><a href="#">Aide</a>
                    </li>
                    <li>
                        <img src="../images/log-out.png" />
                        <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');" class="logout">Logout</a>
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
            <div> <a href="#" class="nav_logo"> <img src="../images/ESTC.png" style="height:30px"><span class="nav_logo-name">Salam</span> </a>
                <div class="nav_list">
                    <a href="internat.php" class="nav_link active">
                        <i class="fas fa-hotel"></i> <span class="nav_name">Map</span>
                    </a>
                    <a href="roomList.php" class="nav_link">
                        <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span>
                    </a>
                    <?php

                    // Check if the user is logged in
                    if (isset($_SESSION['role'])) {
                        // Determine the appropriate href based on the user's role
                        switch ($_SESSION['role']) {
                            case 'Student':
                                $href = 'decharge.php'; // Adjust the link for students
                                break;
                            case 'departement':
                                $href = 'departement_decharge.php';
                                break;
                            case 'internat':
                                $href = 'internat_decharge.php';
                                break;
                            case 'economique':
                                $href = 'economique_decharge.php';
                                break;
                            case 'administration':
                                $href = 'administration_decharge.php';
                                break;
                        }
                    } else {
                        $href = 'login.php';
                    }
                    echo '<a href="' . $href . '" class="nav_link">';
                    echo '<i class="fa fa-copy"></i> <span class="nav_name">Gestion décharge</span>';
                    echo '</a>';

                    if ($_SESSION['role'] === 'internat') {
                        echo '<a href="internat_demandes.php" class="nav_link">';
                        echo '<i class="fa fa-bed"></i> <span class="nav_name">Gestion demandes logement</span>';
                        echo '</a>';
                    }

                    if ($_SESSION['role'] === 'super_admin') {
                        echo '<a href="internat_decharge.php" class="nav_link">';
                        echo '<i class="fa fa-copy"></i> <span class="nav_name">Internat decharge</span>';
                        echo '</a>';
                        echo '<a href="economique_decharge.php" class="nav_link">';
                        echo '<i class="fa fa-copy"></i> <span class="nav_name">Economique decharge</span>';
                        echo '</a>';
                        echo '<a href="administration_decharge.php" class="nav_link">';
                        echo '<i class="fa fa-copy"></i> <span class="nav_name">Administration decharge</span>';
                        echo '</a>';
                    }
                    ?>
                </div>
            </div> <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>



    <h2 style="text-align: center; margin-bottom:2rem;margin-top: 6rem;">Demandes Villes Externes</h2>
    <div class="internatSearch">
        <div class="box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchExterne" name="searchBox" placeholder="Rechercher une demande (par Nom)" onkeyup="searchExterne()">
        </div>
    </div>
    <div id="searchResults">
        <!-- Search results will be displayed here -->
    </div>
    <hr>
    <h2 style="text-align: center; margin-bottom:2rem">Demandes Casablanca</h2>
    <div class="internatSearch">
        <div class="box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchCasa" name="searchBox" placeholder="Rechercher une demande (par Nom)" onkeyup="searchCasa()">
        </div>
    </div>
    <div id="casaResults">
        <!-- Search results will be displayed here -->
    </div>
</body>

</html>