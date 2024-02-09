<?php
include '../includes/user_info.php';
$user_id = $_SESSION['user_id'];
echo $password;
if (isset($_POST['update_profile'])) {
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
    $update_phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $update_country = mysqli_real_escape_string($conn, $_POST['update_country']);
    $update_birthday = mysqli_real_escape_string($conn, $_POST['birthday']); // Assuming the name attribute is 'birthday'
    $update_sexe = mysqli_real_escape_string($conn, $_POST['update_sexe']);
    $update_city = mysqli_real_escape_string($conn, $_POST['update_address']);
    $other_city = mysqli_real_escape_string($conn, $_POST['other_city']);
    $arrondissement = mysqli_real_escape_string($conn, $_POST['arrondissement']);


    $query = "UPDATE `users` SET ";
    if (!empty($update_email)) {
        $query .= "email = '$update_email', ";
    }
    if (!empty($update_phone)) {
        $query .= "tel = '$update_phone', ";
    }
    if (!empty($update_country)) {
        $query .= "pays = '$update_country', ";
    }

    if (!empty($update_birthday)) {
        $query .= "date_naissance = '$update_birthday', ";
    }

    if (!empty($update_sexe)) {
        if ($update_sexe == 'Male') {
            $query .= "genre = 'boy', ";
        }
        if ($update_sexe == 'Femelle') {
            $query .= "genre = 'girl', ";
        }
    }
    if (!empty($update_city)) {
        $query .= "ville = '$update_city', ";
    }
    if (!empty($other_city)) {
        $query .= "ville = '$other_city', ";
    }
    if (!empty($arrondissement)) {
        $query .= "arrondissement = '$arrondissement', ";
    }

    // Remove the trailing comma and space from the query string
    $query = rtrim($query, ', ');
    $query .= " WHERE id = '$user_id'";
    mysqli_query($conn, $query) or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'images/' . $update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $_SESSION['error'] = 'La taille de l\'image est trop grande';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE `users` SET image = '../images/$update_image' WHERE id = '$user_id'") or die('query failed');
            $_SESSION['success'] = 'Image mise à jour avec succès!';
        }
    }

    $new_pass = mysqli_real_escape_string($conn, ($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($conn, ($_POST['confirm_pass']));

    if (!empty($new_pass) || !empty($confirm_pass)) {
        if ($new_pass != $confirm_pass) {
            $_SESSION['error'] = 'Confirmation de nouveau mot de passe incorrecte';
            header("Location: update_pass.php");
            exit();
        } else {
            mysqli_query($conn, "UPDATE `users` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
            $_SESSION['success'] = 'Mot de passe mis à jour avec succès!';
        }
    }
    header("Location: profile.php");
}
