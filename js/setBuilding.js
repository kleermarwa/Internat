let currentBuilding;
$.ajax({
  url: "../includes/fetchUserData.php",
  type: "GET",
  dataType: "json",
  success: function (response) {
    if (response.gender == "boy") {
      currentBuilding = "boys";
    }
    updateRoomLayout();
  },
  error: function (xhr, status, error) {
    console.error("Error:", error);
  },
});
