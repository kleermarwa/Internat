function showPopup() {
  const id = user_id;
  const name = user_name;
  const gender = user_gender;
  const ville = user_ville;
  const roomNumber = d3.select(this).datum().id;
  const popup = document.getElementById("popup");
  const popupRoomNumber = document.getElementById("popupRoomNumber");
  const popupImages = document.getElementById("popupImages");

  $.ajax({
    url: `../includes/getRoomData.php?roomNumber=${roomNumber}&building=${currentBuilding}`,
    type: "GET",
    dataType: "json",
    success: function (data) {
      console.log(data);
      popupRoomNumber.textContent = `Chambre ${roomNumber}`;

      popupImages.innerHTML = "";

      data.forEach((student) => {
        const imageUrl = student.image
          ? student.image
          : "images/default_user.png";

        popupImages.innerHTML += `
                    <div class="student-container">
                        <img src="${imageUrl}" alt="${student.name}">
                        <p>${student.name}</p>
                    </div>
                `;
      });
      const studentCount = data.length;

      $.ajax({
        url: `../includes/getStudentInfo.php?studentId=${id}`,
        type: 'GET',
        dataType: 'json',
        success: function (studentInfo) {

          if (studentCount < 4 && studentInfo.status == 'externe') {
            popupImages.innerHTML += `
                    <div class="edit-room-container">
                        <button class="edit-room-button" onclick="demanderChambre(${roomNumber}, ${id}, '${name}', '${gender}','${ville}')">Demander Chambre
                        <i class="fa fa-plus icon"></i>
                        </button>
                    </div> `;
          } else if (studentCount < 4 && studentInfo.status == 'interne') {
            popupImages.innerHTML += `
                    <div class="edit-room-container">
                        <button class="edit-room-button" onclick="">Demander changement de Chambre
                        <i class="fa fa-plus icon"></i>
                        </button>
                    </div> `;
          }
        },
        error: function (error) {
          console.log('Error:', error);
        }
      });
      popup.style.display = "block";

      document.addEventListener("click", function closepopupOutside(event) {
        if (!popup.contains(event.target)) {
          popup.style.display = "none";
          document.removeEventListener("click", closepopupOutside);
        }
      });
    },
    error: function (error) {
      console.log("Error:", error);
    },
  });
}
