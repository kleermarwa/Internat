// Function to show more information about a specific student
function showStudentInfo(studentId) {
  const infoPopup = document.getElementById("infoPopup");
  // Fetch additional student info using AJAX
  $.ajax({
    url: `../includes/getStudentInfo.php?studentId=${studentId}`,
    type: "GET",
    dataType: "json",
    success: function (studentInfo) {
      // Display additional information in a new popup
      const imageUrl = studentInfo.image
        ? studentInfo.image
        : "images/default_user.png";

      infoPopup.innerHTML = "";

      infoPopup.innerHTML += `
                <div class="card-overlay"></div>
                <div class="card-inner">
                <img src="${imageUrl}" alt="${studentInfo.name}">
                <p class='name'>${studentInfo.name}</p>
                <p style="text-transform: capitalize;">Status: ${studentInfo.status}</p>
                <p>Email: ${studentInfo.email}</p>
                <p>Date de naissance ${studentInfo.date_naissance}</p>
                <p>Ville: ${studentInfo.ville}</p>
                <p>Téléphone: ${studentInfo.tel}</p>
                <p>Fillière: ${studentInfo.filliere}</p>
                <p>Année: ${studentInfo.annee_scolaire}</p>`;

      // Show the popup
      infoPopup.style.display = "block";

      // Close the info popup when clicking outside
      document.addEventListener("click", function closeInfoPopupOutside(event) {
        if (!infoPopup.contains(event.target)) {
          infoPopup.style.display = "none";
          document.removeEventListener("click", closeInfoPopupOutside);
        }
      });
    },
    error: function (error) {
      console.log("Error:", error);
    },
  });
}
