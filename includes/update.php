<?php
include '../includes/user_info.php';
$user_id = $_SESSION['user_id'];
echo $password;
if (isset($_POST['update_profile'])) {
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
    $update_phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $query = "UPDATE `students` SET ";
    if (!empty($update_email)) {
        $query .= "email = '$update_email', ";
    }
    if (!empty($update_phone)) {
        $query .= "tel = '$update_phone', ";
    }

    // Remove the trailing comma and space from the query string
    $query = rtrim($query, ', ');
    $query .= " WHERE id = '$user_id'";
    mysqli_query($conn, $query) or die('query failed');

    $old_pass = $_POST['old_pass'];
    $update_pass = mysqli_real_escape_string($conn, ($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($conn, ($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($conn, ($_POST['confirm_pass']));

    if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        if ($old_pass != $password) {
            $_SESSION['error'] = 'Ancien mot de passe incorrect';
        } elseif ($new_pass != $confirm_pass) {
            $_SESSION['error'] = 'Confirmation de nouveau mot de passe incorrecte';
        } else {
            mysqli_query($conn, "UPDATE `students` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
            $_SESSION['success'] = 'Mot de passe mis à jour avec succès!';
        }
    }

    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'images/' . $update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $_SESSION['error'] = 'La taille de l\'image est trop grande';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE `students` SET image = '../images/$update_image' WHERE id = '$user_id'") or die('query failed');
            $_SESSION['success'] = 'Image mise à jour avec succès!';
        }
    }
    header("Location: updateProfile.php");
}
