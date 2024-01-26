<?php
include 'user_info.php';
$_SESSION['role'] == 'student' ?  null :  header("Location:" . $_SESSION['defaultPage']);
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
                        <img src="images/user.png" /><a href="Student.php">Mon Profile</a>
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
                        <img src="images/log-out.png" />
                        <a href="user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');" class="logout">Logout</a>
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
                        <i class="fas fa-home"></i> <span class="nav_name">Home</span>
                    </a>
                    <a href="index.php" class="nav_link">
                        <i class="fas fa-hotel"></i> <span class="nav_name">Demander chambre</span>
                    </a>
                    <a href="decharge.php" class="nav_link">
                        <i class="fa fa-copy"></i> <span class="nav_name">Demander décharge</span>
                    </a>
                    <a href="" class="nav_link">
                        <i class="fas fa-envelope"></i> <span class="nav_name">Boîte de réception </span>
                    </a>
                </div>
            </div> <a href=""> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>

    <h1 style="font-weight:500; text-align:center;" class="w-100 my-3">
        Bienvenue dans votre Espace Étudiant <br />
        DUT-GI2 2023-2024
    </h1>

    <div class="home-content" style="padding-top: 1em;">
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row d-flex align-items-stretch justify-content-between px-0 px-sm-5">
                    <div style="min-width: 160px; padding: 15px;" class="col-md-3 col-sm-4 mb-3 col-12 d-flex flex-column justify-content-start align-items-center profile-section">
                        <img style="width: 100%; min-width: 150px; max-width: 250px;" src="<?php echo $image ?>" alt="AIT OUFKIR">
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

                            <a class="btn btn-primary m-0 ml-3" style="min-width: 100px;" href="/espaceetudiant/profile/update/">
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