function showPopupStudent(roomNumber) {
    const popup = document.getElementById("popup");
    const popupRoomNumber = document.getElementById("popupRoomNumber");
    const popupImages = document.getElementById("popupImages");

    // Fetch student data using AJAX
    $.ajax({
        url: `getRoomData.php?roomNumber=${roomNumber}&building=${currentBuilding}`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Set room number in popup
            popupRoomNumber.textContent = `Room ${roomNumber}`;

            // Set images and student info in popup
            popupImages.innerHTML = "";

            // Add student data to popup
            data.forEach(student => {
                // Check if the image field is empty, assign a default avatar
                const imageUrl = student.image ? student.image : 'images/default_user.png';

                popupImages.innerHTML += `
                    <div class="student-container">
                        <img src="${imageUrl}" alt="${student.name}">
                        <p>${student.name}</p>
                        <button class="student-container-button" onclick="showStudentInfo(${student.id})">More Info</button>
                    </div>
                `;
            });
            // Add "Edit Room" button

            const studentCount = data.length;

            if (studentCount < 4) {
                popupImages.innerHTML += `
                    <div class="edit-room-container">
                        <button class="edit-room-button" onclick="editRoom(${roomNumber})">Ajouter étudiant
                        <i class="fa fa-plus icon"></i>
                        </button>
                    </div> `;
            }
            // Show the popup
            popup.style.display = "block";

            // Close the info popup when clicking outside
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