<?php
include 'user_info.php';
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
    <script src="../js/navbar.js"></script>
    <style>
        .etudiant-infos tr td {
            padding-bottom: 10px;
        }

        ol,
        ul {
            padding-left: 0rem;
        }

        .profile-section {
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 5px;
        }

        .label {
            font-weight: bold;
            width: 250px;
        }
    </style>
</head>

<body id="body-pd">
    <header id="header" class="header fixed-top">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_txt">
            <h5>Profil</h5>
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
                        <img src="../images/envelope.png" /><a href="../students/internat.php">Inbox</a>
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
                <?php
                if ($_SESSION['role'] == 'student') {
                    echo '<div class="nav_list">';
                    echo '<a href="../includes/profile.php" class="nav_link active">';
                    echo '<i class="fas fa-home"></i> <span class="nav_name">Home</span>';
                    echo '</a>';
                    echo '<a href="../students/index.php" class="nav_link">';
                    echo '<i class="fas fa-hotel"></i> <span class="nav_name">Demander chambre</span>';
                    echo '</a>';
                    echo '<a href="../students/decharge.php" class="nav_link">';
                    echo '<i class="fa fa-copy"></i> <span class="nav_name">Demander décharge</span>';
                    echo '</a>';
                    echo '<a href="../students/internat.php" class="nav_link">';
                    echo '<i class="fas fa-envelope"></i> <span class="nav_name">Boîte de réception </span>';
                    echo '</a>';
                    echo '</div>';
                } else if ($_SESSION['status'] == 'admin') {
                    echo '<a href="../admin/internat.php" class="nav_link active">';
                    echo '<i class="fas fa-hotel"></i> <span class="nav_name">Map</span>';
                    echo '</a>';
                    echo '<a href="../admin/roomList.php" class="nav_link">';
                    echo '<i class="bx bx-grid-alt nav_icon"></i> <span class="nav_name">Dashboard</span>';
                    echo '</a>';
                    
                    if (isset($_SESSION['user_id'])) {
                        switch ($_SESSION['role']) {
                            case 'student':
                                $href = 'decharge.php';
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
                            case 'super_admin':
                                $href = 'departement_decharge.php';
                                break;
                        }
                    } else {
                        $href = 'login.php';
                    }
                    echo '<a href="' . $href . '" class="nav_link">';
                    echo '<i class="fa fa-copy"></i> <span class="nav_name">Gestion décharge</span>';
                    echo '</a>';
                }
                ?>
            </div> <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>

    <h1 style="font-weight:500; padding-top:2rem; text-align:center;" class="w-100 my-3">
        Bienvenue dans votre Espace Gestion Internat
    </h1>

    <div class="home-content" style="padding-top: 1em;">
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row d-flex align-items-stretch justify-content-between px-0 px-sm-5">
                    <div style="min-width: 160px; padding: 15px;" class="col-md-3 col-sm-4 mb-3 col-12 d-flex flex-column justify-content-start align-items-center profile-section">
                        <img style="width: 100%; min-width: 150px; max-width: 250px;" src="<?php echo $image ?>" alt="<?php echo $name ?>">
                    </div>
                    <div class="col-md-8 col-sm-7 mb-3 col-12 profile-section" style="min-width: 290px;">
                        <table class="p-1 mt-3 p-sm-4 etudiant-infos w-100">
                            <tbody>
                                <tr>
                                    <td class="label">Nom Complet</td>
                                    <td><?php echo $name ?></td>
                                    <td class="rtl" style="font-size: 16px;"></td>
                                </tr>
                                <tr>
                                    <td class="label">Fillière</td>
                                    <td><?php echo $filiere ?></td>
                                    <td class="rtl" style="font-size: 16px;"></td>
                                </tr>
                                <tr>
                                    <td class="label">Téléphone</td>
                                    <td><?php echo $tel ?></td>
                                </tr>
                                <tr>
                                    <td class="label">Adresse mail</td>
                                    <td colspan="2"><?php echo $email ?></td>
                                </tr>
                                <tr>
                                    <td class="label">Date de naissance</td>
                                    <td><?php echo $date_naissance ?></td>
                                    <td class="rtl" style="font-size: 16px;"></td>
                                </tr>
                                <tr>
                                    <td class="label">Lieu de naissance</td>
                                    <td><?php echo $ville ?></td>
                                    <td class="rtl" style="font-size: 16px;"></td>
                                </tr>
                                <tr>
                                    <td class="label">Status</td>
                                    <td><?php echo $status ?></td>
                                    <td class="rtl" style="font-size: 16px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-12 d-flex justify-content-end p-0 my-3">

                            <a class="btn btn-primary m-0 ml-3" style="max-width: 100px;" href="../includes/updateProfile.php">
                                Modifier
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>