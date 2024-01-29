
function showStudentInfo(studentId) {
    const infoPopup = document.getElementById("infoPopup");
    $.ajax({
        url: `../includes/getStudentInfo.php?studentId=${studentId}`,
        type: 'GET',
        dataType: 'json',
        success: function (studentInfo) {
            const imageUrl = studentInfo.image ? studentInfo.image : 'images/default_user.png';

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
            if (studentInfo.status === 'interne') {
                infoPopup.innerHTML += `
                <div class='btn'>
                <button style='color:red' onclick="deleteStudent(${studentId})">Supprimer l'étudiant <i class="fa fa-trash"></i></button>
                <button style='color:blue' onclick="moveStudent(${studentId},'${studentInfo.genre}')">Deplacer l'étudiant <i class="fa fa-arrow-right"></i></button>
                </div></div> `;
            }
            else {
                infoPopup.innerHTML += `
                <div class='btn' style='display:block'>
                <button style='color:blue' onclick="moveStudent(${studentId})">Ajouter à une chambre <i class="fa fa-arrow-right"></i></button>
                </div></div> `;
            }

            infoPopup.style.display = "block";

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