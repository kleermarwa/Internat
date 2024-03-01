<?php
include '../includes/user_info.php';
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'internat' || $_SESSION['role'] == 'administration' ?  null :  header("Location:" . $_SESSION['defaultPage']);
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
                    <a href="internatGarcons.php" class="nav_link active">
                        <i class="fa-solid fa-mars"></i> <span class="nav_name">Internat Garçons </span>
                    </a>
                    <a href="internatFilles.php" class="nav_link">
                        <i class="fa-solid fa-venus"></i> <span class="nav_name">Internat Filles </span>
                    </a>
                    <a href="internat_changements.php" class="nav_link ">
                        <i class="fa-solid fa-clock-rotate-left"></i><span class="nav_name">Historique Internat</span>
                    </a>
                    <?php if ($_SESSION['role'] === 'internat') : ?>
                        <a href="internat_decharge_historique.php" class="nav_link">
                            <i class="fa-solid fa-person-walking-arrow-right"></i><span class="nav_name">Historique Décharge</span>
                        </a>
                    <?php endif; ?>
                    <a href="dashboard.php" class="nav_link">
                        <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Tableau de bord</span>
                    </a>
                    <?php if ($_SESSION['role'] === 'administration') : ?>
                        <a href="roomList.php" class="nav_link ">
                            <i class="fa-solid fa-list"></i> <span class="nav_name">Liste des chambres</span>
                        </a>
                    <?php endif; ?>
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
                        echo '<a href="internat_demandes_valide.php" class="nav_link">';
                        echo '<i class="fa-solid fa-bed"></i> <span class="nav_name">Demande Validées</span>';
                        echo '</a>';
                        echo '<a href="internat_demandes_casa.php" class="nav_link">';
                        echo '<i class="fa-regular fa-circle-pause"></i> <span class="nav_name">Demandes Casablanca</span>';
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
                        <i class="fas fa-solid fa-door-open"></i>
                        <span class="label">Rez de chaussée</span>
                        <span class="opt-val">Rez de chaussée</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="1" onclick="changeFloor(2)">
                        <input class="s-c bottom" type="radio" name="platform" value="1" onclick="changeFloor(2)">
                        <i class="fa">1</i>
                        <span class="label">1<sup>er</sup> étage</span>
                        <span class="opt-val">1<sup>er</sup> étage</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="2" onclick="changeFloor(3)">
                        <input class="s-c bottom" type="radio" name="platform" value="2" onclick="changeFloor(3)">
                        <i class="fa">2</i>
                        <span class="label">2<sup>ème</sup> étage</span>
                        <span class="opt-val">2<sup>ème</sup> étage</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="3" onclick="changeFloor(4)">
                        <input class="s-c bottom" type="radio" name="platform" value="3" onclick="changeFloor(4)">
                        <i class="fa">3</i>
                        <span class="label">3<sup>ème</sup> étage</span>
                        <span class="opt-val">3<sup>ème</sup> étage</span>
                    </div>
                    <div class="option">
                        <input class="s-c top" type="radio" name="platform" value="4" onclick="changeFloor(5)">
                        <input class="s-c bottom" type="radio" name="platform" value="4" onclick="changeFloor(5)">
                        <i class="fa">4</i>
                        <span class="label">4<sup>ème</sup> étage</span>
                        <span class="opt-val">4<sup>ème</sup> étage</span>
                    </div>
                    <div id="option-bg"></div>
                </div>
            </div>
        </form>
        <div class="building-mapboy" id="floor1">
            <!-- Row 1 -->
            <div class="room" id="room1" data-room-id="1" onclick="showPopup('room1')">1</div>
            <div class="room" id="room2" data-room-id="2" onclick="showPopup('room2')">2</div>
            <div class="room" id="room3" data-room-id="3" onclick="showPopup('room3')">3</div>
            <div class="room" id="room4" data-room-id="4" onclick="showPopup('room4')">4</div>
            <div class="room" id="room5" data-room-id="5" onclick="showPopup('room5')">5</div>
            <div class="room" id="room6" data-room-id="6" onclick="showPopup('room6')">6</div>
            <div class="room" id="room7" data-room-id="7" onclick="showPopup('room7')">7</div>
            <div class="room" id="room8" data-room-id="8" onclick="showPopup('room8')">8</div>
            <div class="room" id="room9" data-room-id="9" onclick="showPopup('room9')">9</div>
            <div class="room" id="room10" data-room-id="10" onclick="showPopup('room10')">10</div>
            <div class="room" id="room11" data-room-id="11" onclick="showPopup('room11')">11</div>
            <div class="room" id="room22" data-room-id="22" onclick="showPopup('room22')">22</div>
            <div class="room" id="room21" data-room-id="21" onclick="showPopup('room21')">21</div>
            <div class="room" id="room20" data-room-id="20" onclick="showPopup('room20')">20</div>
            <div class="room" id="room19" data-room-id="19" onclick="showPopup('room19')">19</div>
            <div class="room" id="room18" data-room-id="18" onclick="showPopup('room18')">18</div>
            <div class="room" id="room17" data-room-id="17" onclick="showPopup('room17')">17</div>
            <div class="room" id="room16" data-room-id="16" onclick="showPopup('room16')">16</div>
            <div class="room" id="room15" data-room-id="15" onclick="showPopup('room15')">15</div>
            <div class="room" id="room14" data-room-id="14" onclick="showPopup('room14')">14</div>
            <div class="room" id="room13" data-room-id="13" onclick="showPopup('room13')">13</div>
            <div class="room" id="room12" data-room-id="12" onclick="showPopup('room12')">12</div>
        </div>
        <div class="building-mapboy" id="floor2" style="display: none;">
            <div class="room" id="room23" data-room-id="23" onclick="showPopup('room23')">23</div>
            <div class="room" id="room24" data-room-id="24" onclick="showPopup('room24')">24</div>
            <div class="room" id="room25" data-room-id="25" onclick="showPopup('room25')">25</div>
            <div class="room" id="room26" data-room-id="26" onclick="showPopup('room26')">26</div>
            <div class="room" id="room27" data-room-id="27" onclick="showPopup('room27')">27</div>
            <div class="room" id="room28" data-room-id="28" onclick="showPopup('room28')">28</div>
            <div class="room" id="room29" data-room-id="29" onclick="showPopup('room29')">29</div>
            <div class="room" id="room30" data-room-id="30" onclick="showPopup('room30')">30</div>
            <div class="room" id="room31" data-room-id="31" onclick="showPopup('room31')">31</div>
            <div class="room" id="room32" data-room-id="32" onclick="showPopup('room32')">32</div>
            <div class="room" id="room33" data-room-id="33" onclick="showPopup('room33')">33</div>
            <div class="room" id="room34" data-room-id="34" onclick="showPopup('room34')">34</div>
            <div class="room" id="room35" data-room-id="35" onclick="showPopup('room35')">35</div>
            <div class="room" id="room36" data-room-id="36" onclick="showPopup('room36')">36</div>
            <div class="room" id="room37" data-room-id="37" onclick="showPopup('room37')">37</div>
            <div class="room" id="room38" data-room-id="38" onclick="showPopup('room38')">38</div>
            <div class="room" id="room39" data-room-id="39" onclick="showPopup('room39')">39</div>
            <div class="room" id="room40" data-room-id="40" onclick="showPopup('room40')">40</div>
            <div class="room" id="room41" data-room-id="41" onclick="showPopup('room41')">41</div>
            <div class="room" id="room42" data-room-id="42" onclick="showPopup('room42')">42</div>
            <div class="room" id="room43" data-room-id="43" onclick="showPopup('room43')">43</div>
            <div class="room" id="room44" data-room-id="44" onclick="showPopup('room44')">44</div>
        </div>

        <div class="building-mapboy" id="floor3" style="display: none;">
            <div class="room" id="room45" data-room-id="45" onclick="showPopup('room45')">45</div>
            <div class="room" id="room46" data-room-id="46" onclick="showPopup('room46')">46</div>
            <div class="room" id="room47" data-room-id="47" onclick="showPopup('room47')">47</div>
            <div class="room" id="room48" data-room-id="48" onclick="showPopup('room48')">48</div>
            <div class="room" id="room49" data-room-id="49" onclick="showPopup('room49')">49</div>
            <div class="room" id="room50" data-room-id="50" onclick="showPopup('room50')">50</div>
            <div class="room" id="room51" data-room-id="51" onclick="showPopup('room51')">51</div>
            <div class="room" id="room52" data-room-id="52" onclick="showPopup('room52')">52</div>
            <div class="room" id="room53" data-room-id="53" onclick="showPopup('room53')">53</div>
            <div class="room" id="room54" data-room-id="54" onclick="showPopup('room54')">54</div>
            <div class="room" id="room55" data-room-id="55" onclick="showPopup('room55')">55</div>
            <div class="room" id="room56" data-room-id="56" onclick="showPopup('room56')">56</div>
            <div class="room" id="room57" data-room-id="57" onclick="showPopup('room57')">57</div>
            <div class="room" id="room58" data-room-id="58" onclick="showPopup('room58')">58</div>
            <div class="room" id="room59" data-room-id="59" onclick="showPopup('room59')">59</div>
            <div class="room" id="room60" data-room-id="60" onclick="showPopup('room60')">60</div>
            <div class="room" id="room61" data-room-id="61" onclick="showPopup('room61')">61</div>
            <div class="room" id="room62" data-room-id="62" onclick="showPopup('room62')">62</div>
            <div class="room" id="room63" data-room-id="63" onclick="showPopup('room63')">63</div>
            <div class="room" id="room64" data-room-id="64" onclick="showPopup('room64')">64</div>
            <div class="room" id="room65" data-room-id="65" onclick="showPopup('room65')">65</div>
            <div class="room" id="room66" data-room-id="66" onclick="showPopup('room66')">66</div>
        </div>
        <div class="building-mapboy" id="floor4" style="display: none;">
            <div class="room" id="room67" data-room-id="67" onclick="showPopup('room67')">67</div>
            <div class="room" id="room68" data-room-id="68" onclick="showPopup('room68')">68</div>
            <div class="room" id="room69" data-room-id="69" onclick="showPopup('room69')">69</div>
            <div class="room" id="room70" data-room-id="70" onclick="showPopup('room70')">70</div>
            <div class="room" id="room71" data-room-id="71" onclick="showPopup('room71')">71</div>
            <div class="room" id="room72" data-room-id="72" onclick="showPopup('room72')">72</div>
            <div class="room" id="room73" data-room-id="73" onclick="showPopup('room73')">73</div>
            <div class="room" id="room74" data-room-id="74" onclick="showPopup('room74')">74</div>
            <div class="room" id="room75" data-room-id="75" onclick="showPopup('room75')">75</div>
            <div class="room" id="room76" data-room-id="76" onclick="showPopup('room76')">76</div>
            <div class="room" id="room77" data-room-id="77" onclick="showPopup('room77')">77</div>
            <div class="room" id="room78" data-room-id="78" onclick="showPopup('room78')">78</div>
            <div class="room" id="room79" data-room-id="79" onclick="showPopup('room79')">79</div>
            <div class="room" id="room80" data-room-id="80" onclick="showPopup('room80')">80</div>
            <div class="room" id="room81" data-room-id="81" onclick="showPopup('room81')">81</div>
            <div class="room" id="room82" data-room-id="82" onclick="showPopup('room82')">82</div>
            <div class="room" id="room83" data-room-id="83" onclick="showPopup('room83')">83</div>
            <div class="room" id="room84" data-room-id="84" onclick="showPopup('room84')">84</div>
            <div class="room" id="room85" data-room-id="85" onclick="showPopup('room85')">85</div>
            <div class="room" id="room86" data-room-id="86" onclick="showPopup('room86')">86</div>
            <div class="room" id="room87" data-room-id="87" onclick="showPopup('room87')">87</div>
            <div class="room" id="room88" data-room-id="88" onclick="showPopup('room88')">88</div>
        </div>
        <div class="building-mapboy" id="floor5" style="display: none;">
            <div class="room" id="room89" data-room-id="89" onclick="showPopup('room89')">89</div>
            <div class="room" id="room90" data-room-id="90" onclick="showPopup('room90')">90</div>
            <div class="room" id="room91" data-room-id="91" onclick="showPopup('room91')">91</div>
            <div class="room" id="room92" data-room-id="92" onclick="showPopup('room92')">92</div>
            <div class="room" id="room93" data-room-id="93" onclick="showPopup('room93')">93</div>
            <div class="room" id="room94" data-room-id="94" onclick="showPopup('room94')">94</div>
            <div class="room" id="room95" data-room-id="95" onclick="showPopup('room95')">95</div>
            <div class="room" id="room96" data-room-id="96" onclick="showPopup('room96')">96</div>
            <div class="room" id="room97" data-room-id="97" onclick="showPopup('room97')">97</div>
            <div class="room" id="room98" data-room-id="98" onclick="showPopup('room98')">98</div>
            <div class="room" id="room99" data-room-id="99" onclick="showPopup('room99')">99</div>
            <div class="room" id="room100" data-room-id="100" onclick="showPopup('room100')">100</div>
            <div class="room" id="room101" data-room-id="101" onclick="showPopup('room101')">101</div>
            <div class="room" id="room102" data-room-id="102" onclick="showPopup('room102')">102</div>
            <div class="room" id="room103" data-room-id="103" onclick="showPopup('room103')">103</div>
            <div class="room" id="room104" data-room-id="104" onclick="showPopup('room104')">104</div>
            <div class="room" id="room105" data-room-id="105" onclick="showPopup('room105')">105</div>
            <div class="room" id="room106" data-room-id="106" onclick="showPopup('room106')">106</div>
            <div class="room" id="room107" data-room-id="107" onclick="showPopup('room107')">107</div>
            <div class="room" id="room108" data-room-id="108" onclick="showPopup('room108')">108</div>
            <div class="room" id="room109" data-room-id="109" onclick="showPopup('room109')">109</div>
            <div class="room" id="room110" data-room-id="110" onclick="showPopup('room110')">110</div>
        </div>
        <div id="legend">
            <div class="legend-item">
                <div class="legend-color" style="background-color: green;"></div>
                <div class="legend-label">Chambres vides</div>
            </div>

            <div class="legend-item">
                <div class="legend-color" style="background-color: #66ccff;"></div>
                <div class="legend-label">Chambres avec 1 étudiant(e)</div>
            </div>

            <div class="legend-item">
                <div class="legend-color" style="background-color: #d4ce24;"></div>
                <div class="legend-label">Chambres avec 2 étudiant(e)s</div>
            </div>

            <div class="legend-item">
                <div class="legend-color" style="background-color: orange;"></div>
                <div class="legend-label">Chambres avec 3 étudiant(e)s</div>
            </div>

            <div class="legend-item">
                <div class="legend-color" style="background-color: red;"></div>
                <div class="legend-label">Chambres pleines</div>
            </div>

            <div class="legend-item">
                <div class="legend-color" style="background-image: url(../images/stock.png); background-position: center"></div>
                <div class="legend-label">Stock</div>
            </div>
        </div>

    </div>

    <script>
        // // Function to generate room elements dynamically
        // function generateRooms(floorId, startRoomId, endRoomId) {
        //     var floorElement = document.getElementById(floorId);
        //     for (var i = startRoomId; i <= endRoomId; i++) {
        //         var roomElement = document.createElement('div');
        //         roomElement.className = 'room';
        //         roomElement.id = 'room' + i;
        //         roomElement.setAttribute('data-room-id', i);
        //         roomElement.setAttribute('onclick', 'showPopup("room' + i + '")');
        //         roomElement.innerText = i;
        //         floorElement.appendChild(roomElement);
        //     }
        // }


        // generateRooms('floor2', 23, 44);
        // generateRooms('floor3', 45, 66);
        // generateRooms('floor4', 67, 88);
        // generateRooms('floor5', 89, 110);

        let currentBuilding = 'boy'; // Default to boy' Building


        function changeFloor(floorNumber) {
            for (var i = 1; i <= 5; i++) {
                document.getElementById("floor" + i).style.display = "none";
            }
            document.getElementById("floor" + floorNumber).style.display = "grid";

            setRoomColors(floorNumber);
            var currentFloor = floorNumber;
        }

        document.addEventListener('DOMContentLoaded', function() {
            changeFloor(1);
        });
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