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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.0.0/css/countrySelect.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <!-- inserting javascript -->
    <script src="../js/navbar.js"></script>
    <script src="../js/intlTelInput.js"></script>
    <script src="../js/utils.js.js"></script>
    <script src="../js/countrySelect.js"></script>
    <style>
        .required {
            display: flex;
            margin: 1rem auto 1rem auto;
            justify-content: center;
        }

        .box {
            width: 100%;
            height: 55px;
            margin-bottom: 20px;
            outline: none;
            background: whitesmoke;
            font-size: 15px;
            text-align: center;
            border-radius: 5px;
            transition: 0.5s;
            transition-property: border-left, border-right, box-shadow;
            border-radius: 5px;
            border: 1px solid grey;
            padding: 12px 14px;

            &:hover,
            &:focus,
            &:active {
                border-left: solid 5px blue;
                border-right: solid 5px blue;
                box-shadow: 0 0 5px blue;
                border-top: 2px solid blue;
                border-bottom: 2px solid blue;
                transition: 0.3s ease;
            }
        }

        .fields {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            width: 50%;
        }

        .ua {
            color: grey;
            font-size: 1.5rem;
            margin-right: 10px;
            margin-bottom: 17px;

        }
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
    <h2 style="text-align: center;"> Bienvenue dans votre Espace de Demande Internat</h2>
    <h6 style="text-align: center;">Veillez remplir ce formulaire afin de finaliser la creation de votre comptes <span style="font-weight: 500; color:blue">Tous les champs sont obligatoires</span> </h6>
    <p style="text-align: center; font-weight: 700; color:red">Il est crucial d'insérer des données correctes est precises. Tout manquement à cette précision pourrait compromettre la validité des résultats et entraîner des sevères conséquences lors du dépôt de la demande.</p>
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
            <h3>Saisir vos informations personnelles</h3>
            <div>
                <span>Nom et Prénom :</span>
                <div class="fields">
                    <i class="ua fas fa-user-circle"></i>
                    <input type="text" name="update_name" value="<?php echo $name; ?>" class="box" readonly>
                </div>
            </div>
            <div>
                <span>Cin :</span>
                <div class="fields">
                    <i class="ua fas fa-id-card"></i>
                    <input type="text" cin="update_cin" value="<?php echo $cin; ?>" class="box" readonly>
                </div>
                <span>Fillère :</span>
                <div class="fields">
                    <i class="ua fa-solid fa-graduation-cap"></i>
                    <input type="text" cin="update_filliere" value="<?php echo $filiere . " " .  $annee_scolaire; ?>" class="box" readonly>
                </div>
            </div>
            <div class="flex">
                <div class="inputBox" id="info">
                    <span class="required">Votre Email : <span style="color: red;">*</span></span>
                    <div class="field">
                        <i class="ua fas fa-at" aria-hidden="true"></i>
                        <input type="email" name="update_email" value="<?php echo $email; ?>" placeholder="Entrer votre Email" class="box" required>
                    </div>
                    <span class="required">Inserer votre photo : <span style="color: red;">*</span> </span>
                    <div class="field">
                        <i class="ua fas fa-image" aria-hidden="true"></i>
                        <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box" required>
                    </div>
                    <div class="form-item">
                        <span class="required">Votre Sexe : <span style="color: red;">*</span> </span>
                        <div class="field">
                            <i class="ua fas fa-venus-mars" aria-hidden="true"></i>
                            <select name="update_sexe" class="box" required>
                                <?php if (!empty($gender)) : ?>
                                    <option value="<?php echo $gender === 'boy' ? 'Male' : ($gender === 'girl' ? 'Female' : ''); ?>" selected><?php echo $gender === 'boy' ? 'Male' : ($gender === 'girl' ? 'Female' : ''); ?>
                                    </option>
                                    <option value="Male">Male</option>
                                    <option value="Femelle">Femelle</option>
                                <?php else : ?>
                                    <option value="" disabled selected>Selectionner votre sexe</option>
                                    <option value="Male">Male</option>
                                    <option value="Femelle">Femelle</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <span class="required">Votre Date de Naissance : <span style="color: red;">*</span></span>
                    <div class="field">
                        <i class="ua fas fa-birthday-cake" aria-hidden="true"></i>
                        <input type="date" name="birthday" value="<?php echo $date_naissance; ?>" class="box" required>
                    </div>
                </div>

                <div class="inputBox" id="pass">
                    <span class="required">Numéro de téléphone : <span style="color: red;">*</span></span>
                    <div class="field" style="padding-bottom: 1rem;">
                        <i class="ua fas fa-phone" aria-hidden="true" style="margin-bottom: 0px;"></i>
                        <input type="tel" name="phone" id="phone" value="<?php echo $tel; ?>" class="box" required>
                    </div>
                    <div class="form-item">
                        <span class="required">Pays : <span style="color: red;">*</span></span>
                        <div class="field" style="padding-bottom: 1rem;">
                            <i class="ua fas fa-flag" aria-hidden="true" style="margin-bottom: 0px;"></i>
                            <input type="text" name="update_country" value="<?php echo $pays; ?>" id="country_selector" class="box" required>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $("#country_selector").countrySelect({
                                    responsiveDropdown: true,
                                    preferredCountries: ['ma', 'mr', 'sn'],
                                });

                                var input = document.querySelector("#phone");
                                window.intlTelInput(input, {
                                    preferredCountries: ['ma', 'jp'],
                                    defaultCountry: "ma",
                                    autoInsertDialCode: true,
                                    utilsScript: "js/utils.js",
                                });
                            });


                            // Add an event listener to the country selector
                            $("#country_selector").on("change", function() {
                                var countryData = $("#country_selector").countrySelect("getSelectedCountryData");
                                var VilleContainer = document.getElementById('VilleContainer');
                                var villeSelect = document.getElementById('villeSelect');
                                var updateAddressSelect = document.getElementById('villeSelect');
                                var updateCityInput = document.getElementById('CityInput');
                                var updateArrondissementSelect = document.getElementById('arrondissementSelect');

                                // Hide/show Ville based on selected country
                                if (countryData.name !== 'Morocco (‫المغرب‬‎)') {
                                    VilleContainer.style.display = 'none';
                                    streetContainer.style.display = 'none';
                                    CityContainer.style.display = 'none';
                                    villeSelect.value = '';
                                    updateAddressSelect.removeAttribute('required');
                                    updateArrondissementSelect.removeAttribute('required');
                                    updateCityInput.removeAttribute('required');

                                } else if (countryData.name === 'Morocco (‫المغرب‬‎)') {
                                    VilleContainer.style.display = 'block';
                                    updateAddressSelect.setAttribute('required', 'required');
                                }
                                console.log(countryData)

                            });
                        </script>
                    </div>
                    <div id="VilleContainer" style="display:block;">
                        <span class="required">Ville : <span style="color: red;">*</span></span>
                        <div class="field">
                            <i class="ua fas fa-city" aria-hidden="true"></i>
                            <select name="update_address" id="villeSelect" class="box">
                                <?php if (!empty($ville)) : ?>
                                    <option value="<?php echo $ville; ?>" selected><?php echo $ville; ?></option>
                                    <option value="Casablanca">Casablanca</option>
                                    <option value="Autres">Autres</option>
                                <?php else : ?>
                                    <option value="" disabled selected>Selectionner votre Ville</option>
                                    <option value="Casablanca">Casablanca</option>
                                    <option value="Autres">Autres</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div id="CityContainer" style="display:none;">
                        <span class="required">Autre Ville : <span style="color: red;">*</span></span>
                        <div class="field">
                            <i class="ua fas fa-city" aria-hidden="true"></i>
                            <input type="text" name="other_city" id="CityInput" class="box" placeholder="Entrer Votre Ville">
                        </div>
                    </div>

                    <div id="streetContainer" style="display:none;">
                        <span class="required">Arrondissement : <span style="color: red;">*</span></span>
                        <div class="field">
                            <i class="ua fas fa-location-arrow" aria-hidden="true"></i>
                            <select name="arrondissement" id="arrondissementSelect" class="box">
                                <?php if (!empty($ville)) : ?>
                                    <option value="<?php echo $arrondissement; ?>" selected><?php echo $arrondissement; ?></option>
                                <?php else : ?>
                                    <option value="" disabled selected>Selectionner votre Arrondissement</option>
                                <?php endif; ?>
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
                        var updateCityInput = document.getElementById('CityInput');
                        var updateArrondissementSelect = document.getElementById('arrondissementSelect');


                        if (selectedValue === 'Autres') {
                            cityContainer.style.display = 'block';
                            streetContainer.style.display = 'none';
                            updateCityInput.setAttribute('required', 'required');
                            updateArrondissementSelect.removeAttribute('required');

                        } else if (selectedValue === 'Casablanca') {
                            cityContainer.style.display = 'none';
                            streetContainer.style.display = 'block';
                            updateCityInput.removeAttribute('required');
                            updateArrondissementSelect.setAttribute('required', 'required');
                        }
                    });
                </script>
            </div>
            <h3>Modifier votre Mot de Passe</h3>
            <div class="flex">
                <div class="inputBox" id="info">
                    <span class="required">Nouveau mot de passe : <span style="color: red;">*</span> </span>
                    <div class="field">
                        <i class="ua fa fa-lock" aria-hidden="true"></i>
                        <input type="password" name="new_pass" placeholder="Enter new password" class="box" required>
                    </div>
                </div>
                <div class="inputBox" id="pass">
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