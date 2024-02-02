<?php
include '../includes/user_info.php';
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'student' ?  null :  header("Location:" . $_SESSION['defaultPage']);
$_SESSION['student_id'] = $user_id;
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
        .reject {
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            padding-block: 0.5rem;
            padding-inline: 1.25rem;
            background-color: #ca4b4b;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            gap: 10px;
            font-weight: bold;
            border: 3px solid rgba(255, 255, 255, 0.3019607843);
            outline: none;
            overflow: hidden;
            font-size: 15px;
        }

        .reject {
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            padding-block: 0.5rem;
            padding-inline: 1.25rem;
            background-color: #ca4b4b;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            gap: 10px;
            font-weight: bold;
            border: 3px solid rgba(255, 255, 255, 0.3019607843);
            outline: none;
            overflow: hidden;
            font-size: 15px;
        }

        .reject:hover {
            color: white;
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.6);
        }

        .reject:hover::before {
            animation: shine 1.5s ease-out infinite;
        }

        .reject::before {
            content: "";
            position: absolute;
            width: 100px;
            height: 100%;
            background-image: linear-gradient(120deg, rgba(255, 255, 255, 0) 30%, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0) 70%);
            top: 0;
            left: -100px;
            opacity: 0.6;
        }
    </style>
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
            <h5>Votre demande d'internat</h5>
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
                <div class="nav_list">
                    <a href="../includes/profile.php" class="nav_link">
                        <i class="fas fa-home"></i> <span class="nav_name">Home</span>
                    </a>
                    <a href="index.php" class="nav_link">
                        <i class="fas fa-hotel"></i> <span class="nav_name">Demander chambre</span>
                    </a>
                    <a href="decharge.php" class="nav_link">
                        <i class="fa fa-copy"></i> <span class="nav_name">Demander décharge</span>
                    </a>
                    <a href="" class="nav_link active">
                        <i class="fas fa-envelope"></i> <span class="nav_name">Boîte de réception </span>
                    </a>
                </div>
            </div> <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>

    <h2 style="text-align: center; margin-top:6rem">Demande d'Internat</h2>

    <hr>

    <div> <?php
            include 'display_Internatrequests.php';
            ?></div>
</body>

</html>