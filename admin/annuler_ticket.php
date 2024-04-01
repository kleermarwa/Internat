<?php
include '../includes/user_info.php';
include '../includes/searchFull.php';
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'restaurant' ?  null :  header("Location:" . $_SESSION['defaultPage']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Tickets</title>
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
        .event-title {
            line-height: 1.2;
            margin-top: 4rem;
            margin-left: 10px;
            color: red;
        }

        .fc-daygrid-day-number,
        .fc-col-header-cell-cushion {
            color: black;
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
            <h5>Gestion de remise des Tickets - Service de Restauration</h5>
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
                    <a href="restaurant.php" class="nav_link ">
                        <i class="fa-solid fa-utensils"></i> <span class="nav_name">Gestion Tickets</span>
                    </a>
                    <a href="annuler_ticket.php" class="nav_link active">
                        <i class="fa-regular fa-rectangle-xmark"></i></i> <span class="nav_name">Remettre tickets</span>
                    </a>
                    <a href="roomList.php" class="nav_link">
                        <i class="fa-solid fa-list"></i> <span class="nav_name">Liste des chambres</span>
                    </a>
                </div>
            </div> <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>

    <div class="dechargeSearch" style="margin: 5rem auto 0 auto;">
        <div class="box">
            <label for="search" class="fa fa-search"></label>
            <input type="search" placeholder="Rechercher un élève (Par Nom ou Cin)" id="search">
        </div>
    </div>
    <div id="search-results" style="justify-content: center;"></div>

    <hr>

    <div id="studentInfo" style="display:flex;place-content:center;margin:2rem;"></div>
    <div id="calendar"></div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
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
        function loadCalendar(studentId, studentName) {
            $('#studentInfo').html('');
            $.ajax({
                url: 'displayInfo.php',
                method: 'GET',
                data: {
                    id: studentId
                },
                success: function(data) {
                    $('#studentInfo').html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#studentInfo').html('An error occurred while loading data.');
                }
            });

            var searchText = '';
            $('#search').val('');
            $('#search-results').html('');
            $.ajax({
                url: 'load_calendar.php',
                method: 'POST',
                data: {
                    studentId: studentId
                },
                success: function(data) {
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        weekNumbers: true,
                        weekText: 'Semaine ',
                        locale: 'fr',
                        height: 550,
                        firstDay: 1,
                        selectable: true,
                        events: JSON.parse(data),
                        eventContent: function(arg) {
                            return {
                                html: `<div class="event-title">${arg.event.title}</div>`,
                            };
                        },
                        eventDisplay: 'background',

                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                        },

                        dateClick: function(info) {


                            var selectedDate = new Date(info.dateStr);
                            select = selectedDate.getDay();

                            if (select == 5) {
                                var weekStartDate = new Date(selectedDate);
                                weekStartDate.setDate(selectedDate.getDate() - 6); // Adjust for Saturday as the first day                                weekStartDate.setHours(0, 0, 0, 0); // Set hours to midnight for accurate comparison
                                weekStartDate.setHours(0, 0, 0, 0); // Set hours to midnight for accurate comparison

                            } else {
                                var weekStartDate = new Date(selectedDate);
                                weekStartDate.setDate(selectedDate.getDate() - (select + 1) % 7); // Adjust for Saturday as the first day
                                weekStartDate.setHours(0, 0, 0, 0); // Set hours to midnight for accurate comparison

                            }
                            $.ajax({
                                url: 'get_week_end.php',
                                method: 'POST',
                                data: {
                                    studentId: studentId,
                                    weekStartDate: weekStartDate.toISOString().split('T')[0], // Convert to MySQL date format
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        var weekEndDate = new Date(response.weekEndDate);

                                        selectedDate.setDate(selectedDate.getDate() - 1);
                                        var daysDifference = Math.floor((weekEndDate - selectedDate) / (24 * 60 * 60 * 1000));

                                        console.log(selectedDate);
                                        console.log(weekStartDate);
                                        console.log(weekEndDate);
                                        console.log(daysDifference);

                                        var userConfirmation = confirm("Êtes-vous sûr de vouloir remmettre les tickets de " + daysDifference + " jours ?");

                                        if (userConfirmation) {

                                            $.ajax({
                                                url: 'delete_days.php',
                                                method: 'POST',
                                                data: {
                                                    studentId: studentId,
                                                    daysDifference: daysDifference,
                                                    weekStartDate: weekStartDate.toISOString().split('T')[0], // Convert to MySQL date format
                                                },
                                                dataType: 'json',
                                                success: function(response) {
                                                    alert('Tickets remis avec succès.');
                                                    loadCalendar(studentId, studentName)
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('Error subtracting days:', error);
                                                    alert('An error occurred while subtracting days.');
                                                }
                                            });

                                        }
                                    } else {
                                        console.error('Error:', response.message);
                                        alert(response.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error fetching week end date:', error);
                                    alert('An error occurred while fetching week end date.');
                                }
                            });
                        }

                    });
                    calendar.render();
                }
            });
        }
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





</body>

</html>