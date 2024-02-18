function editRoom(roomNumber) {
    const editPopup = document.getElementById("editPopup");
    const editForm = document.getElementById("editForm");
    const studentNameInput = document.getElementById("studentName");
    const studentListContainer = document.getElementById("studentList");
    const closeButton = document.getElementById("editCloseButton");
    
    studentNameInput.value = "";
    studentListContainer.innerHTML = "";
    
    editPopup.style.display = "block";
    
    editForm.onsubmit = function (event) {
        event.preventDefault();
        const studentName = studentNameInput.value;
        
        $.ajax({
            url: `../includes/search.php?term=${studentName}&building='${currentBuilding}'`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {                    
                    data.forEach(student => {
                        const studentItem = document.createElement("div");
                        studentItem.className = "student-list-item";
                        
                        const studentImage = document.createElement("img");
                        studentImage.src = student.image;
                        studentImage.alt = student.label;
                        studentItem.appendChild(studentImage);
                        
                        const studentNameLabel = document.createElement("span");
                        studentNameLabel.textContent = student.label;
                        studentItem.appendChild(studentNameLabel);

                        studentItem.onclick = function () {                            
                            studentNameInput.value = student.label;
                            const confirmAdd = confirm('Etes-vous sûr de vouloir ajouter cet étudiant ?');

                            if (confirmAdd) {                                
                                $.ajax({
                                    url: '../includes/moveStudent.php',
                                    type: 'POST',
                                    data: {
                                        studentId: student.id,
                                        newRoomNumber: roomNumber,
                                        currentBuilding : currentBuilding                                        
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.success) {
                                            alert('Étudiant ajouté avec succès');                                            
                                            editPopup.style.display = 'none';                                                                                        
                                        } else {
                                            alert('Échec de l\'ajout de l\'étudiant');
                                        }
                                    },
                                    error: function (error) {
                                        console.log('Error:', error);
                                    }
                                });
                            };
                        };

                        studentListContainer.appendChild(studentItem);
                        studentNameInput.value = "";

                    });
                } else {
                    alert('Aucun étudiant trouvé');
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    };
    
    closeButton.onclick = function () {        
        editPopup.style.display = 'none';
    };
}
