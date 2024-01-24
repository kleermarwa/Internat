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
    <link rel="stylesheet" href="css/select.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/color.js"></script>
    <script src="js/search.js"></script>
    <script src="js/showPopup.js"></script>
    <script src="js/editRoom.js"></script>
    <script src="js/showPopupStudent.js"></script>
    <script src="js/showStudentInfo.js"></script>
    <script src="js/deleteStudent.js"></script>
    <script src="js/moveStudent.js"></script>
    <script src="js/displayRooms.js"></script>
    <script src="js/navbar.js"></script>
</head>

<body id="body-pd">
    <header id="header" class="header fixed-top">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_txt">
            <h5>Tableau de bord</h5>
        </div>
        <div class="left">
            <div class="search-container">
                <label for="search" class="fa fa-search"></label>
                <input type="search" placeholder="Search Students" id="search">
            </div>
            <div class="notification-icon">
                <a href="cart.php"> <i class="fa fa-bell"></i></a>
                <div class="notification-count"><?php if (isset($user_id)) {
                                                    echo $cart_count;
                                                } ?></div>
            </div>
            <div id="search-results"></div>
        </div>
    </header>

    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> <a href="#" class="nav_logo"> <img src="images/ESTC.png" style="height:30px"><span class="nav_logo-name">Salam</span> </a>
                <div class="nav_list">
                    <a href="index.php" class="nav_link">
                        <i class="fas fa-hotel"></i> <span class="nav_name">Map</span>
                    </a>
                    <a href="roomList.php" class="nav_link active">
                        <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span>
                    </a>
                    <a href="decharge.php" class="nav_link">
                        <i class="fa fa-copy"></i> <span class="nav_name">Gestion décharge</span>
                    </a>
                </div>
            </div> <a href=""> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>

    <!-- Buttons to change buildings -->
    <div class="building">
        <button class="boys" onclick="changeBuilding('boys')">Internat Garçons</button>
        <button class="girls" onclick="changeBuilding('girls')">Internat Filles</button>
    </div>
    <script>
        let currentBuilding = 'boys'; // Default to Boys' Building
        // Function to handle building change
        function changeBuilding(building) {
            currentBuilding = building;
            // Update the table with the new building data
            updateTable();
        }
    </script>
    <div class="RoomList">
        <div class="filters">
            <label for="filter">Filter by Room:</label>
            <select id="filter">
                <option value="all">All Rooms</option>
                <?php
                for ($i = 1; $i <= 110; $i++) {
                    echo "<option value=\"$i\">Room $i</option>";
                }
                ?>
            </select>
        </div>


        <table id="data-table">
            <thead>
                <tr>
                    <th>Chambre</th>
                    <th>Etudiant(e) 1</th>
                    <th>Etudiant(e) 2</th>
                    <th>Etudiant(e) 3</th>
                    <th>Etudiant(e) 4</th>
                    <th>Nombre d'Etudiant(e)s</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded here -->
            </tbody>
        </table>

        <div class='pagination-container'>
            <ul class="pagination">
                <!--	Here the JS Function Will Add the Rows -->
            </ul>
        </div>
    </div>


</body>

</html>