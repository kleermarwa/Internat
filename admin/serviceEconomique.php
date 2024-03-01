<?php
include '../includes/user_info.php';
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'economique' ?  null :  header("Location:" . $_SESSION['defaultPage']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de décharge</title>
    <link rel="shortcut icon" href="../images/ESTC.png" type="image/x-icon">
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/navbar.js"></script>
    <script src="../js/notifications.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #searchResults {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: -webkit-center;
        }

        th {
            background-color: #f2f2f2;
        }

        .image {
            width: 200px;
            height: 200px;
            margin-bottom: 2rem;
        }

        button {
            padding: 5px 10px;
            cursor: pointer;
        }

        .input1,
        .input2 {
            font-weight: 500;
            color: #000;
            box-shadow: 0 0 .4vw rgba(0, 0, 0, 0.5), 0 0 0 .15vw transparent;
            border-radius: 0.4vw;
            border: none;
            outline: none;
            padding: 0.4vw;
            margin-bottom: 1rem;
            transition: .4s;
        }

        .input1:hover {
            box-shadow: 0 0 0 .15vw rgba(135, 207, 235, 0.186);
        }

        .input1:focus {
            box-shadow: 0 0 0 .15vw rgb(92, 184, 92);
        }

        .input2:hover {
            box-shadow: 0 0 0 .15vw rgba(135, 207, 235, 0.186);
        }

        .input2:focus {
            box-shadow: 0 0 0 .15vw rgb(0, 107, 179);
        }
    </style>
</head>

<body id="body-pd">
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="error-message"><?php echo $_SESSION['error'];
                                    unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])) : ?>
        <div class="success-message"><?php echo $_SESSION['success'];
                                        unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <script>
        // Add fade-in, fade-out, and timeout for error and success messages
        $(document).ready(function() {
            $(".error-message, .success-message").fadeIn().delay(3000).fadeOut();
        });
    </script>
    <header id="header" class="header fixed-top">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_txt">
            <h5>Paiement Internat - Service économique </h5>
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
            <div class="notification-icon" onclick="fetchNotifications()">
                <i class="fa fa-bell"></i>
                <div class="notification-count" id="count"><?php echo $count ?></div>
                <div class="notification-dropdown">
                </div>
            </div>
        </div>
    </header>

    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> <a href="#" class="nav_logo"> <img src="../images/ESTC.png" style="height:30px"><span class="nav_logo-name">EST Casablanca</span> </a>
                <div class="nav_list">
                    <a href="dashboard.php" class="nav_link">
                        <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Tableau de bord</span>
                    </a>
                    <a href="roomList.php" class="nav_link">
                        <i class="fa-solid fa-list"></i> <span class="nav_name">Liste des chambres</span>
                    </a>
                    <a href="economique_decharge.php" class="nav_link">
                        <i class="fa fa-copy"></i> <span class="nav_name">Gestion décharge</span>
                    </a>
                    <a href="serviceEconomique.php" class="nav_link active">
                        <i class="fa-solid fa-sack-dollar"></i> <span class="nav_name">Payement internat</span>
                    </a>
                </div>
            </div> <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>

    <h2 style="text-align: center; margin-top:6rem">Paiement Internat</h2>
    <div class="dechargeSearch">
        <div class="box">
            <label for="search" class="fa fa-search"></label>
            <input type="search" placeholder="Rechercher un élève (Par Nom ou Cin)" id="search">
        </div>
    </div>
    <div id="search-results" style="justify-content: center;"></div>
    <hr>

    <div id="searchResults"> </div>
    <script>
        const searchInput = document.getElementById('search');
        const searchResults = document.getElementById('search-results');

        searchInput.addEventListener('input', function() {
            if (searchInput.value.trim() !== '') {
                searchResults.style.display = 'block';
            } else {
                searchResults.style.display = 'none';
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var searchText = $(this).val();
                if (searchText != '') {
                    $.ajax({
                        url: '../includes/searchFull.php',
                        method: 'POST',
                        data: {
                            query: searchText
                        },
                        success: function(data) {
                            $('#search-results').html(data);
                        }
                    });
                } else {
                    $.ajax({
                        url: '../includes/searchFull.php',
                        method: 'POST',
                        data: {
                            query: ''
                        },
                        success: function(data) {
                            $('#search-results').html(data);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        function loadPayment(id) {
            var searchText = '';

            $('#search').val('');

            $('#search-results').html('');

            $.ajax({
                type: "GET",
                url: "../admin/serviceEconomiquesearch.php",
                data: {
                    id: id,
                },
                success: function(response) {
                    $("#searchResults").html(response);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed: " + error);
                },
            });
        }
    </script>
</body>

</html>