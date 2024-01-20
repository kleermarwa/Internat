// Function to show more information about a specific student
function showStudentInfo(studentId) {
    // Fetch additional student info using AJAX
    $.ajax({
        url: `getStudentInfo.php?studentId=${studentId}`,
        type: 'GET',
        dataType: 'json',
        success: function (studentInfo) {
            // Display additional information in a new popup
            const infoPopup = document.createElement("div");
            const imageUrl = studentInfo.image ? studentInfo.image : 'images/default_user.png';
            infoPopup.className = "info-popup";

            infoPopup.innerHTML = `
                <div class="card-overlay"></div>
                <div class="card-inner">
                <img src="${imageUrl}" alt="${studentInfo.name}">
                <p class='name'>${studentInfo.name}</p>
                <p>Email: ${studentInfo.email}</p>
                <p>Date de naissance ${studentInfo.date_naissance}</p>
                <p>Ville: ${studentInfo.ville}</p>
                <p>Téléphone: ${studentInfo.tel}</p>
                <p>Fillière: ${studentInfo.filliere}</p>
                <p>Année: ${studentInfo.annee_scolaire}</p>
                <div class='btn'>;
                <button style='color:red' onclick="deleteStudent(${studentId})">Supprimer l'élève</button>
                <button style='color:blue' onclick="moveStudent(${studentId})">Deplacer l'élève</button>
                </div></div>
            `;

            document.body.appendChild(infoPopup);

            // Close the info popup when clicking outside
            document.addEventListener("click", function closeInfoPopupOutside(event) {
                if (!infoPopup.contains(event.target)) {
                    infoPopup.style.display = "none";
                    document.removeEventListener("click", closeInfoPopupOutside);
                }
            });
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}