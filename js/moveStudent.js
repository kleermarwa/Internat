// Function to move a student to another room
function moveStudent(studentId) {
    // Prompt the user for the new room number
    const newRoomNumber = prompt('Enter the new room number:');

    // Check if the input is valid
    if (newRoomNumber !== null && !isNaN(newRoomNumber) && newRoomNumber !== '') {
        // Send AJAX request to move student
        $.ajax({
            url: 'moveStudent.php',
            type: 'POST',
            dataType: 'json',
            data: {
                studentId: studentId,
                newRoomNumber: newRoomNumber
            },
            success: function (response) {
                if (response.success) {
                    alert('Student moved successfully');
                    // Close the info popup
                    document.querySelector('.info-popup').style.display = 'none';
                } else {
                    if (response.error === 'Invalid room number') {
                        alert('Invalid room number');
                    } else if (response.error === 'Room is already full') {
                        alert('Room is already full');
                    } else {
                        alert('Failed to move student');
                    }
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    } else {
        alert('Invalid room number');
    }
}
// Function to close the popup
function closePopup() {
    document.getElementById("popup").style.display = "none";
}