<?php
session_start();
// echo $_SESSION['status'];
// echo $_SESSION['role'];
// echo $_SESSION['user_id'];
include 'db_connect.php';
if (!isset($_SESSION['role'])) {
    header('Location: ../includes/login.php');
    exit;
}
// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    switch ($_SESSION['role']) {
        case 'student':
            $href = '../includes/student.php';
            break;
        case 'departement':
            $href = '../admin/internat.php';
            break;
        case 'internat':
            $href = '../admin/internat.php';
            break;
        case 'economique':
            $href = '../admin/internat.php';
            break;
        case 'administration':
            $href = '../admin/internat.php';
            break;
        case 'super_admin':
            $href = '../admin/internat.php';
            break;
    }

    $_SESSION['defaultPage'] = $href;

    if (isset($_SESSION['role'])) {
        $user_id = $_SESSION['user_id'];
        $result = $conn->query("SELECT * FROM users WHERE id='$user_id'");

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
            $gender = $row['genre'];
            $status = $row['status'];
            $annee_scolaire = $row['annee_scolaire'];

            if (file_exists($image)) {
                $user_image = $image;
            } else {
                $user_image = 'images/default_user.png';
            }
        }
    } else {
        header('Location: ../includes/login.php');
    }
}
$sqlcount = "SELECT decharge.*, users.*
    FROM decharge
    JOIN users ON decharge.student_id = users.id";

if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'departement':
            $sqlcount .= " WHERE decharge.read_departement = 0 AND decharge.valide_departement = 0";
            break;
        case 'internat':
            $sqlcount .= " AND decharge.read_internat = 0 AND decharge.valide_departement = 1 AND decharge.valide_internat = 0";
            break;
        case 'economique':
            $sqlcount .= " AND decharge.read_economique = 0 AND decharge.valide_departement = 1 AND decharge.valide_internat = 1 AND decharge.valide_economique = 0";
            break;
        case 'administration':
            $sqlcount .= " AND decharge.read_administartion = 0 AND decharge.valide_departement = 1 AND decharge.valide_internat = 1 AND decharge.valide_economique = 1 AND decharge.valide_administration = 0";
            break;
    }
}
$result = $conn->query($sqlcount);
$notifications = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}
$count = count($notifications);


if (isset($_GET['logout'])) {
    unset($user_id);
    unset($role);
    session_destroy();
    header("Location: login.php");
};    
    // elseif (isset($_GET['id'])) {

    // Check if user ID is set
//     $id = $_GET['id'];
    // Connect to database
    // Get customer details from database
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
