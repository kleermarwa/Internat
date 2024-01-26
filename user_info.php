<?php
session_start();
include 'db_connect.php';
// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'student') {
        // User is logged in, display name, email, and image
        $user_id = $_SESSION['user_id'];
        // Query the database to get user information
        $result = $conn->query("SELECT * FROM students WHERE id='$user_id'");

        // $count_query = "SELECT COUNT(*) as count FROM cart WHERE user_id = '$user_id'";
        // $count_result = mysqli_query($mysqli, $count_query);
        // $count_row = mysqli_fetch_assoc($count_result);
        // $cart_count = $count_row['count'];

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $email = $row['email'];
            $image = $row['image'];
            $room = $row['room_number'];
            $filiere = $row['filliere'];
            $password = $row['password'];
            $date_naissance = $row['date_naissance'];
            $ville = $row['ville'];
            $tel = $row['tel'];
            $status = $row['status'];
            $annee_scolaire = $row['annee_scolaire'];

            // check if user's image exists, otherwise display default image
            if (file_exists($image)) {
                $user_image = $image;
            } else {
                $user_image = 'images/user.png';
            }
        }
    }
} else {
    header('Location: login.php');
}
// elseif (isset($_GET['id'])) {
//     // Check if user ID is set
//     $id = $_GET['id'];

//     // Connect to database
//     // Get customer details from database
//     $result = $conn->query("SELECT * FROM user_info WHERE id='$id'");

//     if ($result->num_rows == 1) {
//         $row = $result->fetch_assoc();
//         $name = $row['name'];
//         $email = $row['email'];
//         $image = $row['image'];
//         $country = $row['country'];
//         $address = $row['address'];
//         $postal_code = $row['postal_code'];
//         $phone = $row['phone'];

//         // check if user's image exists, otherwise display default image
//         if (file_exists($image)) {
//             $user_image = $image;
//         } else {
//             $user_image = 'images/default_user.png';
//         }
//     }
// }

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header("Location: login.php");
};
