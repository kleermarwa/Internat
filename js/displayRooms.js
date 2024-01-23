$(document).ready(function () {
    const rowsPerPage = 25; // Number of rows to display per page
    const totalRooms = 110; // Total number of rooms
    const $dataTable = $('#data-table tbody');
    const $pagination = $('.pagination');

    // Function to fetch and display room data for a specific page
    function fetchAndDisplayPage(pageNumber) {
        // Calculate the range of rooms to fetch for the current page
        const startRoom = (pageNumber - 1) * rowsPerPage + 1;
        const endRoom = Math.min(pageNumber * rowsPerPage, totalRooms);

        // Iterate through rooms in the current page
        for (let roomNumber = startRoom; roomNumber <= endRoom; roomNumber++) {
            // Make an AJAX request for each room
            $.ajax({
                url: `getRoomData.php?roomNumber=${roomNumber}&building=${currentBuilding}`,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    // Handle the response and populate the table
                    displayRoomData(response, roomNumber);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data for room ' + roomNumber + ': ' + error);
                }
            });
        }
    }

    // Function to display room data in the table
    function displayRoomData(data, roomNumber) {
        // Create a new row for each room
        var row = '<tr>';
        row += '<td>' + roomNumber + '</td>';

        // Iterate through each student in the room
        for (var i = 0; i < 4; i++) {
            if (i < data.studentCount) {
                row += '<td>' + data.data[i].name + '</td>';
            } else {
                // If there are fewer than 4 students, leave the remaining cells empty
                row += '<td></td>';
            }
        }

        row += '<td>' + data.studentCount + '</td>';
        row += '</tr>';

        // Append the row to the table body
        $dataTable.append(row);
    }

    // Function to update pagination links
    function updatePaginationLinks(currentPage) {
        $pagination.empty();
        for (let i = 1; i <= Math.ceil(totalRooms / rowsPerPage); i++) {
            const $pageLink = $('<li><a href="#">' + i + '</a></li>');
            $pageLink.click(function () {
                $dataTable.empty(); // Clear existing data before fetching and displaying new page
                fetchAndDisplayPage(i);
                updatePaginationLinks(i);
            });
            if (i === currentPage) {
                $pageLink.addClass('active');
            }
            $pagination.append($pageLink);
        }
    }

    // Initially fetch and display the first page
    fetchAndDisplayPage(1);

    // Initially update pagination links for the first page
    updatePaginationLinks(1);
});
