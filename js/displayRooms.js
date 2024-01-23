// roomList.js

document.addEventListener("DOMContentLoaded", function () {
    // Function to fetch and display room list
    function fetchRoomList(building) {
        // Fetch room data using AJAX
        for (let roomNumber = 1; roomNumber <= 10; roomNumber++) {
            $.ajax({
                url: `getRoomData.php?roomNumber=${roomNumber}&building=${building}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    displayRoomList(data);
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        }
    }

 // Function to display room list in the table
 function displayRoomList(data) {
    // Select the table body where the list will be displayed
    const tableBody = document.querySelector("#data-table tbody");

    // Clear existing content
    tableBody.innerHTML = "";

    // Iterate through all rooms (110 rooms)
    for (let roomNumber = 1; roomNumber <= 10; roomNumber++) {
        // Find the room data for the current room number
        const room = data.find(room => room.room_number === roomNumber);

        // Create a table row for each room
        var tableRow = '<tr>';
        tableRow += '<td>' + roomNumber + '</td>';

        // Iterate through each student in the room
        for (let i = 0; i < 4; i++) {
            if (room && i < room.students.length) {
                tableRow += '<td>' + room.students[i].name + '</td>';
            } else {
                // If there are fewer than 4 students, leave the remaining cells empty
                tableRow += '<td>-</td>';
            }
        }

        // Add student count to the row
        const studentCountCell = '<td>' + (room ? room.students.length : 0) + '</td>';
        tableRow += studentCountCell;

        // Append the row to the table body
        tableRow += '</tr>';
        tableBody.innerHTML += tableRow;
    }
}

    // Fetch room list for boys (initial load)
    fetchRoomList('boys');

    // Event listeners for building buttons
    const boysButton = document.getElementById("boysButton");
    const girlsButton = document.getElementById("girlsButton");

    boysButton.addEventListener("click", function () {
        fetchRoomList('boys');
    });

    girlsButton.addEventListener("click", function () {
        fetchRoomList('girls');
    });
});
