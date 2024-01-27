let user_name;
let user_id;
let user_gender;
let user_ville;

$.ajax({
  url: "../includes/fetchUserData.php",
  type: "GET",
  dataType: "json",
  success: function (response) {
    user_name = response.name;
    user_id = response.id;
    user_gender = response.gender;
    user_ville = response.ville;
  },
  error: function (xhr, status, error) {
    console.error("Error:", error);
  },
});
