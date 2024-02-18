function setRoomColors(floorNumber) {
    var rooms = document.querySelectorAll('#floor' + floorNumber + ' .room');

    rooms.forEach(function (room) {
        var roomId = room.getAttribute('data-room-id');

        // AJAX call to get the number of students in each room
        $.ajax({
            url: '../includes/getStudentsCount.php',
            type: 'GET',
            data: {
                roomId: roomId,
                building: currentBuilding
            },
            dataType: 'json',
            success: function (response) {
                var numStudents = response.numStudents;
                var roomColor = getRoomColor(numStudents);
                // Set the background color of the room
                room.style.backgroundColor = roomColor;
            },
            error: function (xhr, status, error) {
                console.error('AJAX error: ' + error);
            }
        });
    });
}


function getRoomColor(numStudents) {
    switch (numStudents) {
        case 0:
            return '#175e15';
        case 1:
            return '#66ccff';
        case 2:
            return '#d4ce24';
        case 3:
            return 'orange';
        case 4:
            return 'red';
        default:
            return '#b3b3b3';
    }
}// function getRoomColor(roomId, buildingData, currentFloor) {
//     const room = buildingData[currentFloor].find(room => room.id === roomId);

//     if (!room || room.type !== 'room') {
//         return '#b3b3b3';
//     }

//     const numStudents = getNumStudentsInRoom(room.id);

//     switch (numStudents) {
//         case 0:
//             return '#175e15';
//         case 1:
//             return '#66ccff';
//         case 2:
//             return '#d4ce24';
//         case 3:
//             return 'orange';
//         case 4:
//             return 'red';
//         default:
//             return '#b3b3b3';
//     }
// }

// function getNumStudentsInRoom(roomId) {
//     let numStudents = 0;

//     $.ajax({
//         url: `../includes/getStudentsCount.php?roomId=${roomId}&building=${currentBuilding}`,
//         type: 'GET',
//         dataType: 'json',
//         async: false,
//         success: function (response) {
//             if (response.success) {
//                 numStudents = response.numStudents;
//             } else {
//                 console.error('Failed to get students count:', response.message);
//             }
//         },
//         error: function (error) {
//             console.error('Error:', error);
//         }
//     });

//     return numStudents;
// }