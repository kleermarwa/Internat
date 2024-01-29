function deleteStudent(studentId) {    
    const confirmDelete = confirm('Etes-vous sûr de vouloir supprimer cet étudiant de la chambre?');

    if (confirmDelete) {        
        $.ajax({
            url: '../includes/deleteStudent.php',
            type: 'POST',
            data: {
                studentId: studentId
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    alert('Student deleted successfully');                    
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