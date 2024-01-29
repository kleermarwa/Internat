function getRoomColor(roomId, buildingData, currentFloor) {
    const room = buildingData[currentFloor].find(room => room.id === roomId);

    if (!room || room.type !== 'room') {
        return '#b3b3b3';
    }

    const numStudents = getNumStudentsInRoom(room.id);

    switch (numStudents) {
        case 0:
            return '#175e15';
        case 1:
            return '#66ccff';
        case 2:
            return '#d6cf09';
        case 3:
            return 'orange';
        case 4:
            return 'red';
        default:
            return '#b3b3b3';
    }
}

function getNumStudentsInRoom(roomId) {
    let numStudents = 0;

    $.ajax({
        url: `../includes/getStudentsCount.php?roomId=${roomId}&building=${currentBuilding}`,
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function (response) {
            if (response.success) {
                numStudents = response.numStudents;
            } else {
                console.error('Failed to get students count:', response.message);
            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });

    return numStudents;
}