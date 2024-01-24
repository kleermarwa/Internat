// Function to get the color based on the number of students in the room
function getRoomColor(roomId, buildingData, currentFloor) {
    const room = buildingData[currentFloor].find(room => room.id === roomId);

    if (!room || room.type !== 'room') {
        return '#b3b3b3'; // Default color for non-room elements
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
            return '#b3b3b3'; // Default color for unexpected cases
    }
}

// Function to get the number of students in a room
function getNumStudentsInRoom(roomId) {
    let numStudents = 0;

    // Use AJAX to fetch data from the PHP file
    $.ajax({
        url: `getStudentsCount.php?roomId=${roomId}&building=${currentBuilding}`,
        type: 'GET',
        dataType: 'json',
        async: false, // Make the AJAX call synchronous to wait for the result
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