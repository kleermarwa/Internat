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
    <header id="header" class="header fixed-top">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_txt">
            <h5>Demande de décharge</h5>
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

    <h1>Demande de décharge</h1>

    <form action="submit_request.php" method="post">
        <button type="submit" name="create_request">Créer une demande</button>
    </form>

    <hr>

    <div> <?php
            include 'display_requests.php';
            ?></div>
</body>

</html>