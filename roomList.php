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
    <link rel="stylesheet" href="css/select.css">
    <link rel="stylesheet" href="css/sass.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/color.js"></script>
    <script src="js/search.js"></script>
    <script src="js/showPopup.js"></script>
    <script src="js/editRoom.js"></script>
    <script src="js/showPopupStudent.js"></script>
    <script src="js/showStudentInfo.js"></script>
    <script src="js/deleteStudent.js"></script>
    <script src="js/moveStudent.js"></script>
    <script src="js/displayRooms.js"></script>

</head>
<style>

.RoomList {
    margin-top: 20rem; /* Changed from 30rem to 3rem for a more reasonable margin */
}

.filters {
    margin-bottom: 20px;
}

.pagination-container {
    text-align: center;
    margin-top: 20px;
    clear: both;
}

#data-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    padding: 12px; /* Adjusted padding for better spacing */
    text-align: left;
    border: 1px solid #ddd;
    width: 120px; /* Set fixed width for each cell */
}

th {
    background-color: #f2f2f2;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Pagination Links */
.pagination {
    display: inline-block;
    padding: 0;
    margin: 0;
    list-style: none;
}

.pagination li {
    display: inline;
    margin-right: 5px;
}

.pagination a {
    text-decoration: none;
    padding: 10px 14px; /* Adjusted padding for better touch interaction */
    border: 1px solid #ccc;
    background-color: #f8f8f8;
    color: #333;
    border-radius: 3px;
}

.pagination a:hover {
    background-color: #e0e0e0;
}

.pagination .active a {
    background-color: #428bca;
    color: #fff;
}

/* Responsive Styles */
@media screen and (max-width: 768px) {
    th, td {
        width: auto; /* Remove fixed width for smaller screens */
    }
}


</style>

<body>
    <!-- Room map container -->

    <header id="header" class="fixed-top" style="background: none;">
        <div class="fa fa-bars"></div>
        <div class="left">
            <div class="search-container">
                <label for="search" class="fa fa-search"></label>
                <input type="search" placeholder="Search Students" id="search">
            </div>
            <div id="search-results"></div>
        </div>
        <!-- navbar  -->
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="categories.php">Product</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
        </nav>
    </header>
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
                <th>Room</th>
                <th>Student1</th>
                <th>Student2</th>
                <th>Student3</th>
                <th>Student4</th>
                <th>Student Count</th>
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