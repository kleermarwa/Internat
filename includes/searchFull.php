<?php
// Include database connection file
include 'db_connect.php';

$previous_page = $_SERVER['HTTP_REFERER'];

if (isset($_POST['query'])) {
    $searchText = $_POST['query'];

    // Perform database query
    if (!empty($searchText)) {
        $query = "SELECT id, CIN,image,filliere, name FROM users WHERE (name LIKE '%$searchText%' OR cin LIKE '%$searchText%') AND status != 'admin' ";
        if (strpos($previous_page, 'restaurant.php') !== false) {
            $query .= "AND status = 'interne'";
        }
        $result = $conn->query($query);

        // Display search results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (strpos($previous_page, 'restaurant.php') !== false) {
                    echo '<div class="search-result" onclick="loadCalendar(' . htmlspecialchars(json_encode($row['id']), ENT_QUOTES) . ', \'' . htmlspecialchars($row['name'], ENT_QUOTES) . '\')">';
                    echo "<span><img src='" . $row['image'] . "' style='height:100px'></span><br>";
                    echo "<span>" . $row['CIN'] . "</span><br>";
                    echo "<span>" . $row['name'] . "</span><br>";
                    echo "<span>" . $row['filliere'] . "</span><br>";
                    echo "</div>";
                } elseif (strpos($previous_page, 'serviceEconomique.php') !== false) {
                    echo '<div class="search-result" onclick="loadPayment(' . htmlspecialchars(json_encode($row['id']), ENT_QUOTES) . ')">';
                    echo "<span><img src='" . $row['image'] . "' style='height:100px'></span><br>";
                    echo "<span>" . $row['CIN'] . "</span><br>";
                    echo "<span>" . $row['name'] . "</span><br>";
                    echo "<span>" . $row['filliere'] . "</span><br>";
                    echo "</div>";
                }
            }
        } else {
            echo "No results found";
        }
    }
}

// Close connection
$conn->close();
