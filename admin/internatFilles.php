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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/select.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/color.js"></script>
    <script src="../js/search.js"></script>
    <script src="../js/showPopup.js"></script>
    <script src="../js/editRoom.js"></script>
    <script src="../js/showPopupStudent.js"></script>
    <script src="../js/showStudentInfo.js"></script>
    <script src="../js/deleteStudent.js"></script>
    <script src="../js/moveStudent.js"></script>
    <script src="../js/navbar.js"></script>
    <script src="../js/notifications.js"></script>
</head>

<body id="body-pd">
    <header id="header" class="header fixed-top">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_txt">
            <h5>Gestion de l'internat</h5>
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
            <div class="search-container">
                <label for="search" class="fa fa-search"></label>
                <input type="search" placeholder="Search Students" id="search">
            </div>
            <div class="notification-icon" onclick="fetchNotifications()">
                <i class="fa fa-bell"></i>
                <div class="notification-count" id="count"><?php echo $count ?></div>
                <div class="notification-dropdown">
                </div>
            </div>

            <div id="search-results"></div>
        </div>
    </header>

    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> <a href="#" class="nav_logo"> <img src="../images/ESTC.png" style="height:30px"><span class="nav_logo-name">EST Casablanca</span> </a>
                <div class="nav_list">
                    <a href="internatGarcons.php" class="nav_link ">
                        <i class="fa-solid fa-mars"></i> <span class="nav_name">Internat Garçons </span>
                    </a>
                    <a href="internatFilles.php" class="nav_link active">
                        <i class="fa-solid fa-venus"></i> <span class="nav_name">Internat Filles </span>
                    </a>
                    <a href="dashboard.php" class="nav_link">
                        <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Tableau de bord</span>
                    </a>
                    <a href="roomList.php" class="nav_link">
                        <i class="fa-solid fa-list"></i> <span class="nav_name">Liste des chambres</span>
                    </a>
                    <?php

                    if (isset($_SESSION['role'])) {
                        switch ($_SESSION['role']) {
                            case 'Student':
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
                        }
                    } else {
                        $href = 'login.php';
                    }
                    echo '<a href="' . $href . '" class="nav_link">';
                    echo '<i class="fa fa-copy"></i> <span class="nav_name">Gestion décharge</span>';
                    echo '</a>';
                    if ($_SESSION['role'] === 'administration') {
                        echo '<a href="decharge_valide.php" class="nav_link">';
                        echo '<i class="fa fa-file"></i> <span class="nav_name">Gestion décharge</span>';
                        echo '</a>';
                    }
                    if ($_SESSION['role'] === 'internat') {
                        echo '<a href="internat_demandes.php" class="nav_link">';
                        echo '<i class="fa fa-bed"></i> <span class="nav_name">Gestion demandes logement</span>';
                        echo '</a>';
                        echo '<a href="internat_demandes_valide.php" class="nav_link">';
                        echo '<i class="fa-solid fa-file-circle-check"></i> <span class="nav_name">Demande Validées</span>';
                        echo '</a>';
                        echo '<a href="internat_demandes_refuse.php" class="nav_link">';
                        echo '<i class="fa-solid fa-file-circle-xmark"></i> <span class="nav_name">Demande Refusées</span>';
                        echo '</a>';
                    }
                    ?>
                </div>
            </div> <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>
    <div id="roomMap">
        <div class="popup" id="popup">
            <p style="margin-top: 0.5rem; font-size: 17px">Informations Chambre</p>
            <p id="popupRoomNumber"></p>
            <div id="popupImages"></div>
        </div>
        <div class="info-popup" id="infoPopup"></div>

        <div class="popup" id="editPopup">
            <p>Ajouter étudiant</p>
            <form id="editForm">
                <label for="studentName">Nom de l'étudiant:</label>
                <input type="text" id="studentName" required>
                <button class="submit" type="submit">Chercher l'étudiant</button>
                <div id="studentList"></div>
                <button class="submit" style="background:red;" id="editCloseButton">Fermer</button>

            </form>
        </div>
        <!-- Floor Selector Form -->
        <form id="app-cover">
            <div id="select-box">
                <input type="checkbox" id="options-view-button">
                <div id="select-button" class="brd">
                    <div id="selected-value">
                        <span>Naviguer étage</span>
                    </div>
                    <div id="chevrons">
                        <i class="fas fa-chevron-up"></i>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <div id="options">
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="1" onclick="changeFloor(1)">
                        <input class="s-c bottom" type="radio" name="platform" value="1" onclick="changeFloor(1)">
                        <i class="fa">1</i>
                        <span class="label">1<sup>er</sup> étage</span>
                        <span class="opt-val">1<sup>er</sup> étage</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="2" onclick="changeFloor(2)">
                        <input class="s-c bottom" type="radio" name="platform" value="2" onclick="changeFloor(2)">
                        <i class="fa">2</i>
                        <span class="label">2<sup>ème</sup> étage</span>
                        <span class="opt-val">2<sup>ème</sup> étage</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="3" onclick="changeFloor(3)">
                        <input class="s-c bottom" type="radio" name="platform" value="3" onclick="changeFloor(3)">
                        <i class="fa">3</i>
                        <span class="label">3<sup>ème</sup> étage</span>
                        <span class="opt-val">3<sup>ème</sup> étage</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="4" onclick="changeFloor(4)">
                        <input class="s-c bottom" type="radio" name="platform" value="4" onclick="changeFloor(4)">
                        <i class="fa">4</i>
                        <span class="label">4<sup>ème</sup> étage</span>
                        <span class="opt-val">4<sup>ème</sup> étage</span>
                    </div>
                    <div id="option-bg"></div>
                </div>
            </div>
        </form>
        <div class="building-map" id="floor1">
            <!-- Row 1 -->
            <div class="room stock" id="room100" data-room-id="100">100</div>
            <div class="room " id="room101" data-room-id="101" onclick="showPopup('room101')">101</div>
            <div class="room stock" id="room102" data-room-id="102">102</div>
            <div class="room" id="room103" data-room-id="103" onclick="showPopup('room103')">103</div>
            <div class="room" id="room104" data-room-id="104" onclick="showPopup('room104')">104</div>
            <div class="room" id="room105" data-room-id="105" onclick="showPopup('room105')">105</div>
            <div class="room" id="room106" data-room-id="106" onclick="showPopup('room106')">106</div>
            <div class="room" id="room107" data-room-id="107" onclick="showPopup('room107')">107</div>
            <div class="room" id="room108" data-room-id="108" onclick="showPopup('room108')">108</div>

            <!-- Extended divider with more meaningful styling -->
            <div class="divider" style="height:110%"></div>

            <!-- 2nd half -->
            <div class="room" id="room115" data-room-id="115" onclick="showPopup('room115')">115</div>
            <div class="room" id="room118" data-room-id="118" onclick="showPopup('room118')">118</div>
            <div class="room" id="room120" data-room-id="120" onclick="showPopup('room120')">120</div>
            <div class="room" id="room122" data-room-id="122" onclick="showPopup('room122')">122</div>
            <div class="room" id="room124" data-room-id="124" onclick="showPopup('room124')">124</div>
            <div class="room" id="room126" data-room-id="126" onclick="showPopup('room126')">126</div>

            <!-- Row 2 -->
            <div class="room" id="room109" data-room-id="109" onclick="showPopup('room109')">109</div>
            <div class="room" id="room110" data-room-id="110" onclick="showPopup('room110')">110</div>
            <div class="room" id="room111" data-room-id="111" onclick="showPopup('room111')">111</div>
            <div class="room" id="room112" data-room-id="112" onclick="showPopup('room112')">112</div>
            <div class="room" id="room113" data-room-id="113" onclick="showPopup('room113')">113</div>
            <div class="room" id="room114" data-room-id="114" onclick="showPopup('room114')">114</div>
            <div class="room" id="room117" data-room-id="117" onclick="showPopup('room117')">117</div>
            <div class="room" id="room128" data-room-id="128" onclick="showPopup('room128')">128</div>
            <div class="room" id="room129" data-room-id="129" onclick="showPopup('room129')">129</div>

            <!-- Extended divider with more meaningful styling -->
            <div class="divider"></div>

            <!-- 2nd half -->
            <div class="room" id="room116" data-room-id="116" onclick="showPopup('room116')">116</div>
            <div class="room" id="room119" data-room-id="119" onclick="showPopup('room119')">119</div>
            <div class="room" id="room121" data-room-id="121" onclick="showPopup('room121')">121</div>
            <div class="room" id="room123" data-room-id="123" onclick="showPopup('room123')">123</div>
            <div class="room stock" id="room125" data-room-id="125">125</div>
            <div class="room" id="room127" data-room-id="127" onclick="showPopup('room127')">127</div>

        </div>

        <!-- Floor 2 -->
        <div class="building-mapS" id="floor2" style="display: none;">
            <div class="room stock" id="room200" data-room-id="200">200</div>
            <div class="room" id="room201" data-room-id="201" onclick="showPopup('room201')">201</div>
            <div class="room stock" id="room202" data-room-id="202">202</div>
            <div class="room" id="room203" data-room-id="203" onclick="showPopup('room203')">203</div>
            <div class="room" id="room204" data-room-id="204" onclick="showPopup('room204')">204</div>
            <div class="room" id="room205" data-room-id="205" onclick="showPopup('room205')">205</div>
            <div class="room" id="room206" data-room-id="206" onclick="showPopup('room206')">206</div>
            <div class="room" id="room207" data-room-id="207" onclick="showPopup('room207')">207</div>
            <div class="room" id="room208" data-room-id="208" onclick="showPopup('room208')">208</div>
            <div class="room" id="room209" data-room-id="209" onclick="showPopup('room209')">209</div>
            <div class="room" id="room210" data-room-id="210" onclick="showPopup('room210')">210</div>
            <div class="room" id="room211" data-room-id="211" onclick="showPopup('room211')">211</div>
            <div class="room" id="room212" data-room-id="212" onclick="showPopup('room212')">212</div>
            <div class="room" id="room213" data-room-id="213" onclick="showPopup('room213')">213</div>
            <div class="room" id="room214" data-room-id="214" onclick="showPopup('room214')">214</div>

            <div class="room" id="room215" data-room-id="215" onclick="showPopup('room215')">215</div>
            <div class="room" id="room216" data-room-id="216" onclick="showPopup('room216')">216</div>
            <div class="room" id="room217" data-room-id="217" onclick="showPopup('room217')">217</div>
            <div class="room" id="room218" data-room-id="218" onclick="showPopup('room218')">218</div>
            <div class="room" id="room219" data-room-id="219" onclick="showPopup('room219')">219</div>
            <div class="room" id="room220" data-room-id="220" onclick="showPopup('room220')">220</div>
            <div class="room" id="room221" data-room-id="221" onclick="showPopup('room221')">221</div>
            <div class="room" id="room222" data-room-id="222" onclick="showPopup('room222')">222</div>
            <div class="room" id="room223" data-room-id="223" onclick="showPopup('room223')">223</div>
            <div class="room" id="room224" data-room-id="224" onclick="showPopup('room224')">224</div>
            <div class="room stock" id="room225" data-room-id="225">225</div>
            <div class="room" id="room226" data-room-id="226" onclick="showPopup('room226')">226</div>
            <div class="room" id="room227" data-room-id="227" onclick="showPopup('room227')">227</div>
            <div class="room" id="room228" data-room-id="228" onclick="showPopup('room228')">228</div>
            <div class="room" id="room229" data-room-id="229" onclick="showPopup('room229')">229</div>

        </div>

        <!-- Floor 3 -->
        <div class="building-mapS" id="floor3" style="display: none;">
            <div class="room stock" id="room300" data-room-id="300">300</div>
            <div class="room" id="room301" data-room-id="301" onclick="showPopup('room301')">301</div>
            <div class="room stock" id="room302" data-room-id="302">302</div>
            <div class="room" id="room303" data-room-id="303" onclick="showPopup('room303')">303</div>
            <div class="room" id="room304" data-room-id="304" onclick="showPopup('room304')">304</div>
            <div class="room" id="room305" data-room-id="305" onclick="showPopup('room305')">305</div>
            <div class="room" id="room306" data-room-id="306" onclick="showPopup('room306')">306</div>
            <div class="room" id="room307" data-room-id="307" onclick="showPopup('room307')">307</div>
            <div class="room" id="room308" data-room-id="308" onclick="showPopup('room308')">308</div>
            <div class="room" id="room309" data-room-id="309" onclick="showPopup('room309')">309</div>
            <div class="room" id="room310" data-room-id="310" onclick="showPopup('room310')">310</div>
            <div class="room" id="room311" data-room-id="311" onclick="showPopup('room311')">311</div>
            <div class="room" id="room312" data-room-id="312" onclick="showPopup('room312')">312</div>
            <div class="room" id="room313" data-room-id="313" onclick="showPopup('room313')">313</div>
            <div class="room" id="room314" data-room-id="314" onclick="showPopup('room314')">314</div>

            <div class="room" id="room315" data-room-id="315" onclick="showPopup('room315')">315</div>
            <div class="room" id="room316" data-room-id="316" onclick="showPopup('room316')">316</div>
            <div class="room" id="room317" data-room-id="317" onclick="showPopup('room317')">317</div>
            <div class="room" id="room318" data-room-id="318" onclick="showPopup('room318')">318</div>
            <div class="room" id="room319" data-room-id="319" onclick="showPopup('room319')">319</div>
            <div class="room" id="room320" data-room-id="320" onclick="showPopup('room320')">320</div>
            <div class="room" id="room321" data-room-id="321" onclick="showPopup('room321')">321</div>
            <div class="room" id="room322" data-room-id="322" onclick="showPopup('room322')">322</div>
            <div class="room" id="room323" data-room-id="323" onclick="showPopup('room323')">323</div>
            <div class="room" id="room324" data-room-id="324" onclick="showPopup('room324')">324</div>
            <div class="room stock" id="room325" data-room-id="325">325</div>
            <div class="room" id="room326" data-room-id="326" onclick="showPopup('room326')">326</div>
            <div class="room" id="room327" data-room-id="327" onclick="showPopup('room327')">327</div>
            <div class="room" id="room328" data-room-id="328" onclick="showPopup('room328')">328</div>
            <div class="room" id="room329" data-room-id="329" onclick="showPopup('room329')">329</div>
        </div>

        <!-- Floor 4 -->
        <div class="building-mapS" id="floor4" style="display: none;">
            <div class="room stock" id="room400" data-room-id="400">400</div>
            <div class="room" id="room401" data-room-id="401" onclick="showPopup('room401')">401</div>
            <div class="room stock" id="room402" data-room-id="402">402</div>
            <div class="room" id="room403" data-room-id="403" onclick="showPopup('room403')">403</div>
            <div class="room" id="room404" data-room-id="404" onclick="showPopup('room404')">404</div>
            <div class="room" id="room405" data-room-id="405" onclick="showPopup('room405')">405</div>
            <div class="room" id="room406" data-room-id="406" onclick="showPopup('room406')">406</div>
            <div class="room" id="room407" data-room-id="407" onclick="showPopup('room407')">407</div>
            <div class="room" id="room408" data-room-id="408" onclick="showPopup('room408')">408</div>
            <div class="room" id="room409" data-room-id="409" onclick="showPopup('room409')">409</div>
            <div class="room" id="room410" data-room-id="410" onclick="showPopup('room410')">410</div>
            <div class="room" id="room411" data-room-id="411" onclick="showPopup('room411')">411</div>
            <div class="room" id="room412" data-room-id="412" onclick="showPopup('room412')">412</div>
            <div class="room" id="room413" data-room-id="413" onclick="showPopup('room413')">413</div>
            <div class="room" id="room414" data-room-id="414" onclick="showPopup('room414')">414</div>

            <div class="room" id="room415" data-room-id="415" onclick="showPopup('room415')">415</div>
            <div class="room" id="room416" data-room-id="416" onclick="showPopup('room416')">416</div>
            <div class="room" id="room417" data-room-id="417" onclick="showPopup('room417')">417</div>
            <div class="room" id="room418" data-room-id="418" onclick="showPopup('room418')">418</div>
            <div class="room" id="room419" data-room-id="419" onclick="showPopup('room419')">419</div>
            <div class="room" id="room420" data-room-id="420" onclick="showPopup('room420')">420</div>
            <div class="room" id="room421" data-room-id="421" onclick="showPopup('room421')">421</div>
            <div class="room" id="room422" data-room-id="422" onclick="showPopup('room422')">422</div>
            <div class="room" id="room423" data-room-id="423" onclick="showPopup('room423')">423</div>
            <div class="room" id="room424" data-room-id="424" onclick="showPopup('room424')">424</div>
            <div class="room stock" id="room425" data-room-id="425">425</div>
            <div class="room" id="room426" data-room-id="426" onclick="showPopup('room426')">426</div>
            <div class="room" id="room427" data-room-id="427" onclick="showPopup('room427')">427</div>
            <div class="room" id="room428" data-room-id="428" onclick="showPopup('room428')">428</div>
            <div class="room" id="room429" data-room-id="429" onclick="showPopup('room429')">429</div>
        </div>
    </div>

    <!-- Update the existing script tag -->
    <script>
        let currentBuilding = 'girls'; // Default to Boys' Building
        function changeFloor(floorNumber) {
            // Hide all floors
            for (var i = 1; i <= 4; i++) {
                document.getElementById("floor" + i).style.display = "none";
            }

            // Show the selected floor
            document.getElementById("floor" + floorNumber).style.display = "grid";

            // Fetch and set the color for each room on the selected floor
            setRoomColors(floorNumber);
        }

        // Call setRoomColors when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Assuming you want to initially show the floor 1
            changeFloor(1);
        });
        // Event listener for document click to close the dropdown
        document.addEventListener("click", function(event) {
            var dropdown = document.getElementById("options-view-button");
            var dropdownContainer = document.getElementById("options");

            // Check if the clicked element is not inside the dropdown or its container
            if (!dropdownContainer.contains(event.target) && event.target !== dropdown) {
                // Close the dropdown by unchecking the checkbox
                dropdown.checked = false;
            }
        });

        // Event listener for radio inputs to close the dropdown when a value is selected
        var radioInputs = document.querySelectorAll('#options input[type="radio"]');
        radioInputs.forEach(function(radioInput) {
            radioInput.addEventListener("change", function() {
                // Close the dropdown by unchecking the checkbox
                document.getElementById("options-view-button").checked = false;
            });
        });
    </script>


</body>

</html>