function showPopup(roomId) {
    const roomNumber = document.getElementById(roomId).getAttribute('data-room-id');
    const popup = document.getElementById("popup");
    const popupRoomNumber = document.getElementById("popupRoomNumber");
    const popupImages = document.getElementById("popupImages");

    $.ajax({
        url: `../includes/getRoomData.php?roomNumber=${roomNumber}&building=${currentBuilding}`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            popupRoomNumber.textContent = `Chambre ${roomNumber}`;

            popupImages.innerHTML = "";

            data.forEach(student => {
                const imageUrl = student.image ? student.image : 'images/default_user.png';

                popupImages.innerHTML += `
                    <div class="student-container">
                        <img src="${imageUrl}" alt="${student.name}">
                        <p>${student.name}</p>
                        <button class="student-container-button" onclick="showStudentInfo(${student.id})">Plus d'infos</button>                        
                    </div>
                `;
            });
            const studentCount = data.length;

            if (studentCount < 4) {
                popupImages.innerHTML += `
                    <div class="edit-room-container">
                        <button class="edit-room-button" onclick="editRoom(${roomNumber})">Ajouter étudiant
                        <i class="fa fa-plus icon"></i>
                        </button>
                    </div> `;
            }
            popup.style.display = "block";

            document.addEventListener("click", function closepopupOutside(event) {
                if (!popup.contains(event.target)) {
                    popup.style.display = "none";
                    document.removeEventListener("click", closepopupOutside);
                }
            });

        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}
