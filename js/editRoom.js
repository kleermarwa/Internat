function editRoom(roomNumber) {
    const editPopup = document.getElementById("editPopup");
    const editForm = document.getElementById("editForm");
    const studentNameInput = document.getElementById("studentName");
    const studentListContainer = document.getElementById("studentList");
    const closeButton = document.getElementById("editCloseButton");

    // Clear the form fields and student list
    studentNameInput.value = "";
    studentListContainer.innerHTML = "";

    // Show the editing popup
    editPopup.style.display = "block";

    // Handle form submission
    editForm.onsubmit = function (event) {
        event.preventDefault();

        // Get the value from the form
        const studentName = studentNameInput.value;

        // Validate the input (you can add more validation as needed)

        // Make an AJAX call to search for the student
        $.ajax({
            url: `search.php?term=${studentName}&building=${currentBuilding}`,
            type: 'GET',
            dataType: 'json',   
            success: function (data) {
                if (data.length > 0) {
                    // Display the list of students
                    data.forEach(student => {
                        const studentItem = document.createElement("div");
                        studentItem.className = "student-list-item";

                        // Display the student image
                        const studentImage = document.createElement("img");
                        studentImage.src = student.image;
                        studentImage.alt = student.label;
                        studentItem.appendChild(studentImage);

                        // Display the student name
                        const studentNameLabel = document.createElement("span");
                        studentNameLabel.textContent = student.label;
                        studentItem.appendChild(studentNameLabel);

                        studentItem.onclick = function () {
                            // Set the selected student in the input field
                            studentNameInput.value = student.label;
                            const confirmAdd = confirm('Etes-vous sûr de vouloir ajouter cet étudiant ?');

                            if (confirmAdd) {
                                // Make another AJAX call to move the student to the selected room
                                $.ajax({
                                    url: 'moveStudent.php',
                                    type: 'POST',
                                    data: {
                                        studentId: student.id,
                                        newRoomNumber: roomNumber
                                        // Add other form fields as needed
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.success) {
                                            alert('Student added successfully');
                                            // Close the editing popup
                                            editPopup.style.display = 'none';
                                            // Refresh the room data or update the UI as needed
                                            // You may need to call showPopup or updateRoomLayout function
                                        } else {
                                            alert('Failed to add student');
                                        }
                                    },
                                    error: function (error) {
                                        console.log('Error:', error);
                                    }
                                });
                            };
                        };

                        studentListContainer.appendChild(studentItem);
                    });
                } else {
                    alert('No students found');
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    };

    // Handle close button click
    closeButton.onclick = function () {
        // Close the editing popup
        editPopup.style.display = 'none';
    };
}
