<?php
include '../includes/user_info.php';
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Mon Profil</title>
    <link rel="shortcut icon" href="../images/ESTC.png" type="image/x-icon">
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/navbar.js"></script>
    <script src="../js/countrySelect.js"></script>
    <script src="../js/intlTelInput.js"></script>
    <script src="../js/utils.js"></script>
</head>

<body id="body-pd">
    <?php if (isset($_SESSION['error'])) : ?>
        <div style="margin-bottom: 0;" class="error-message" onclick="this.remove()"><?php echo $_SESSION['error'];
                                                                                        unset($_SESSION['error']); ?></div style="margin-bottom: 0;">
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])) : ?>
        <div style="margin-bottom: 0;" class="success-message" onclick="this.remove()"><?php echo $_SESSION['success'];
                                                                                        unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <header id="header" class="header fixed-top">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_txt">
            <h5>Modifier Mon Profil</h5>
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
            <div> <a href="#" class="nav_logo"> <img src="../images/ESTC.png" style="height:30px"><span class="nav_logo-name">EST Casablanca</span> </a>
                <?php
                if ($_SESSION['role'] == 'student') {
                    echo '<a href="../students/internat.php" class="nav_link">';
                    echo '<i class="fas fa-hotel"></i> <span class="nav_name">Boîte de réception </span>';
                    echo '</a>';
                    echo '<div class="nav_list">';
                    echo '<a href="../includes/profile.php" class="nav_link active">';
                    echo '<i class="fas fa-home"></i> <span class="nav_name">Home</span>';
                    echo '</a>';
                    echo '<a href="../students/decharge.php" class="nav_link">';
                    echo '<i class="fa fa-copy"></i> <span class="nav_name">Demander décharge</span>';
                    echo '</a>';
                    echo '</div>';
                } else if ($_SESSION['status'] == 'admin') {
                    echo '<a href="../admin/    " class="nav_link active">';
                    echo '<i class="fas fa-hotel"></i> <span class="nav_name">Map</span>';
                    echo '</a>';
                    echo '<a href="../admin/roomList.php" class="nav_link">';
                    echo '<i class="bx bx-grid-alt nav_icon"></i> <span class="nav_name">Tableau de bord</span>';
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

    <div class="update-profile">
        <form id="forma" action="update.php" method="post" enctype="multipart/form-data">
            <?php
            if (isset($messageErr)) {
                foreach ($messageErr as $messageErr) {
                    echo '<div class="messageErr">' . $messageErr . '</div>';
                }
            } else if (isset($messageSuc)) {
                foreach ($messageSuc as $messageSuc) {
                    echo '<div class="messageSuc">' . $messageSuc . '</div>';
                }
            }
            ?>
            <img src="<?php echo $user_image; ?>" alt="User Avatar">
            <div class="flex">
                <div class="inputBox" id="info">
                    <h3>Modifier vos informations personnelles</h3>
                    <span>Nom et Prénom :</span>
                    <div class="field">
                        <i class="ua fas fa-user-circle"></i>
                        <input type="text" name="update_name" value="<?php echo $name; ?>" class="box" readonly>
                    </div>
                    <span>Votre Email :</span>
                    <div class="field">
                        <i class="ua fas fa-at" aria-hidden="true"></i>
                        <input type="email" name="update_email" value="<?php echo $email; ?>" class="box">
                    </div>
                    <span>Mettez à jour votre photo :</span>
                    <div class="field">
                        <i class="ua fas fa-image" aria-hidden="true"></i>
                        <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
                    </div>
                    <span>Numéro de téléphone :</span>
                    <div class="field" style="padding-bottom: 1rem;">
                        <i class="ua fas fa-phone" aria-hidden="true" style="margin-bottom: 0px;"></i>
                        <input type="tel" name="phone" id="phone" value="<?php echo $tel; ?>" class="box">
                    </div>
                </div>
                <div class="inputBox" id="pass">
                    <h3>Modifier votre Mot de Passe</h3>
                    <input type="hidden" value="<?php echo $password; ?>">
                    <span>Ancien mot de passe :</span>
                    <div class="field">
                        <i class="ua fa fa-lock" aria-hidden="true"></i>
                        <input type="password" name="old_pass" placeholder="Enter previous password" class="box">
                    </div>
                    <span>Nouveau mot de passe :</span>
                    <div class="field">
                        <i class="ua fa fa-lock" aria-hidden="true"></i>
                        <input type="password" name="new_pass" placeholder="Enter new password" class="box">
                    </div>
                    <span>Confirmer le mot de passe :</span>
                    <div class="field">
                        <i class="ua fa fa-unlock" aria-hidden="true"></i>
                        <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
                    </div>
                </div>
            </div>
            <input type="submit" value="Confirmer Modifications" name="update_profile" class="btn">
            <a href="../includes/profile.php" class="delete-btn">Retourner</a>
        </form>

    </div>

</body>

</html>