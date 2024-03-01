
function moveStudent(studentId, currentBuilding) {
    const newRoomNumber = prompt('Entrez le numéro de la nouvelle chambre:');

    if (newRoomNumber !== null && !isNaN(newRoomNumber) && newRoomNumber !== '') {
        $.ajax({
            url: '../includes/moveStudent.php',
            type: 'POST',
            dataType: 'json',
            data: {
                studentId: studentId,
                newRoomNumber: newRoomNumber,
                currentBuilding: currentBuilding
            },
            success: function (response) {
                console.log(response) ;
                setRoomColors(1);
                if (response.success) {
                    alert('L\'étudiant a déplacé avec succès');
                    document.querySelector('.info-popup').style.display = 'none';
                } else {
                    if (response.error === 'Numéro de chambre invalide') {
                        alert('Numéro de chambre invalide');
                    } else if (response.error === 'La chambre est déjà pleine') {
                        alert('La chambre est déjà pleine');
                    } else if (response.error === 'La chambre est de type stock') {
                        alert('La chambre est de type stock');
                    } else {
                        alert('Échec du déplacement de l\'étudiant');
                    }
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    } else {
        alert('Numéro de chambre invalide');
    }
}
function closePopup() {
    document.getElementById("popup").style.display = "none";
}