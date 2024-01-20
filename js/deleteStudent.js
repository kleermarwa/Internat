function deleteStudent(studentId) {
    // Show a confirmation dialog
    const confirmDelete = confirm('Etes-vous sûr de vouloir supprimer cet élève de la chambre?');

    if (confirmDelete) {
        // Proceed with deletion
        $.ajax({
            url: 'deleteStudent.php',
            type: 'POST',
            data: {
                studentId: studentId
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    alert('Student deleted successfully');
                    // Close the info popup
                    document.querySelector('.info-popup').style.display = 'none';
                } else {
                    alert('Failed to delete student');
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
}