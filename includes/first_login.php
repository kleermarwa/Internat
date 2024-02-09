<?php
include '../includes/user_info.php';
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Mon Profil</title>
    <link rel="shortcut icon" href="../images/ESTC.png" type="image/x-icon">
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.0.0/css/countrySelect.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <!-- inserting javascript -->
    <script src="../js/navbar.js"></script>
    <script src="../js/countrySelect.js"></script>
    <script src="../js/intlTelInput.js"></script>
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
        <form id="forma" action="first_login_update.php" method="post" enctype="multipart/form-data">
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
            <div class="flex">
                <div class="inputBox" id="info">
                    <h3>Modifier vos informations personnelles</h3>
                    <span>Nom et Prénom :</span>
                    <div class="field">
                        <i class="ua fas fa-user-circle"></i>
                        <input type="text" name="update_name" value="<?php echo $name; ?>" class="box" readonly>
                    </div>
                    <span>Votre Email :</span>
                    <div class="field">
                        <i class="ua fas fa-at" aria-hidden="true"></i>
                        <input type="email" name="update_email" value="<?php echo $email; ?>" class="box">
                    </div>
                    <span class="required">Mettez à jour votre photo : <span style="color: red;">*</span> </span>
                    <div class="field">
                        <i class="ua fas fa-image" aria-hidden="true"></i>
                        <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box" required>
                    </div>
                    <span>Numéro de téléphone :</span>
                    <div class="field" style="padding-bottom: 1rem;">
                        <i class="ua fas fa-phone" aria-hidden="true" style="margin-bottom: 0px;"></i>
                        <input type="tel" name="phone" id="phone" value="<?php echo $tel; ?>" class="box">
                    </div>
                    <div class="form-item">
                        <span>Pays :</span>
                        <div class="field" style="padding-bottom: 1rem;">
                            <i class="ua fas fa-flag" aria-hidden="true" style="margin-bottom: 0px;"></i>
                            <input type="text" name="update_country" id="country_selector" class="box">
                        </div>
                        <script>
                            $(document).ready(function() {
                                $("#country_selector").countrySelect({
                                    defaultCountry: "ma",
                                });

                                var input = document.querySelector("#phone");
                                window.intlTelInput(input, {
                                    preferredCountries: ['ma', 'jp'],
                                    utilsScript: "js/utils.js",
                                });
                            });

                            // Add an event listener to the country selector
                            $("#country_selector").on("change", function() {
                                var selectedCountry = $(this).val();
                                var VilleContainer = document.getElementById('VilleContainer');

                                // Hide/show Ville based on selected country
                                if (selectedCountry !== "ma") {
                                    VilleContainer.style.display = 'none';
                                } else {
                                    VilleContainer.style.display = 'block';
                                }
                            });
                        </script>
                    </div>
                    <div id="VilleContainer" style="display:block;">
                        <span>Ville :</span>
                        <div class="field">
                            <i class="ua fas fa-city" aria-hidden="true"></i>
                            <select name="update_address" id="villeSelect" class="box">
                                <option value="" disabled selected>Selectionner votre Ville</option>
                                <option value="Casablanca">Casablanca</option>
                                <option value="Autres">Autres</option>
                            </select>
                        </div>
                    </div>

                    <div id="CityContainer" style="display:none;">
                        <span>Autre Ville :</span>
                        <div class="field">
                            <i class="ua fas fa-city" aria-hidden="true"></i>
                            <input type="text" name="City" id="CityInput" class="box" placeholder="Entrer Votre Ville">
                        </div>
                    </div>

                    <div id="streetContainer" style="display:none;">
                        <span>Arrondissement :</span>
                        <div class="field">
                            <i class="ua fas fa-location-arrow" aria-hidden="true"></i>
                            <select name="arrondissement" id="arrondissementSelect" class="box">
                                <option value="" disabled selected>Selectionner votre Arrondissement</option>
                                <option value="Aïn Chock">Aïn Chock</option>
                                <option value="Aïn Sebaâ">Aïn Sebaâ</option>
                                <option value="Al Fida">Al Fida</option>
                                <option value="Anfa">Anfa</option>
                                <option value="Ben M'sik">Ben M'sik</option>
                                <option value="Essoukhour Assawda">Essoukhour Assawda</option>
                                <option value="Hay Hassani">Hay Hassani</option>
                                <option value="Hay Mohammadi">Hay Mohammadi</option>
                                <option value="Maârif">Maârif</option>
                                <option value="Mers Sultan">Mers Sultan</option>
                                <option value="Moulay Rachid">Moulay Rachid</option>
                                <option value="Sbata">Sbata</option>
                                <option value="Sidi Belyout">Sidi Belyout</option>
                                <option value="Sidi Bernoussi">Sidi Bernoussi</option>
                                <option value="Sidi Moumen">Sidi Moumen</option>
                                <option value="Sidi Othman">Sidi Othman</option>
                            </select>
                        </div>
                    </div>
                </div>

                <script>
                    // JavaScript code
                    document.getElementById('villeSelect').addEventListener('change', function() {
                        var selectedValue = this.value;

                        // Hide/show input containers based on selected option
                        var cityContainer = document.getElementById('CityContainer');
                        var streetContainer = document.getElementById('streetContainer');

                        if (selectedValue === 'Autres') {
                            cityContainer.style.display = 'block';
                            streetContainer.style.display = 'none';
                        } else if (selectedValue === 'Casablanca') {
                            cityContainer.style.display = 'none';
                            streetContainer.style.display = 'block';
                        } else {
                            cityContainer.style.display = 'none';
                            streetContainer.style.display = 'none';
                        }
                    });
                </script>

                <div class="inputBox" id="pass">
                    <h3>Modifier votre Mot de Passe</h3>
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