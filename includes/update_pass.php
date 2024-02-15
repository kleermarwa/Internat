<?php
include '../includes/user_info.php';
$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Mon Profil</title>
    <link rel="shortcut icon" href="../images/ESTC.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- inserting javascript -->
    <script src="../js/navbar.js"></script>
    <style>

    </style>

</head>

<body id="body-pd">
    <?php if (isset($_SESSION['error'])) : ?>
        <div style="margin-bottom: 0;" class="error-message" onclick="this.remove()"><?php echo $_SESSION['error'];
                                                                                        unset($_SESSION['error']); ?></div style="margin-bottom: 0;">
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])) : ?>
        <div style="margin-bottom: 0;" class="success-message" onclick="this.remove()"><?php echo $_SESSION['success'];
                                                                                        unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="update-profile">
        <form id="forma" action="" method="post" enctype="multipart/form-data">
            <?php
            if (isset($messageErr)) {
                foreach ($messageErr as $messageErr) {
                    echo '<div class="messageErr">' . $messageErr . '</div>';
                }
            } else if (isset($messageSuc)) {
                foreach ($messageSuc as $messageSuc) {
                    echo '<div class="messageSuc">' . $messageSuc . '</div>';
                }
            }
            ?>
            <img src="<?php echo $user_image; ?>" alt="User Avatar">
            <h3>Modifier votre Mot de Passe</h3>

            <div class="flex">
                <div class="inputBox" style="margin: auto;">
                    <span class="required">Nouveau mot de passe : <span style="color: red;">*</span> </span>
                    <div class="field">
                        <i class="ua fa fa-lock" aria-hidden="true"></i>
                        <input type="password" name="new_pass" placeholder="Enter new password" class="box" required>
                    </div>

                    <span class="required">Confirmer le mot de passe : <span style="color: red;">*</span> </span>
                    <div class="field">
                        <i class="ua fa fa-unlock" aria-hidden="true"></i>
                        <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box" required>
                    </div>
                </div>
            </div>
            <input type="submit" value="Confirmer Modifications" name="update_profile" class="btn">
            <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" class="delete-btn">Logout</a>

        </form>
    </div>
</body>

</html>