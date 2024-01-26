const roomsPerPage = 22;
let currentPage = 1;

// Function to display data in the table with pagination
function displayData(building) {
    // Remove existing rows from the table
    $('#data-table tbody').empty();

    // Calculate the start and end indices based on the current page
    const startIndex = (currentPage - 1) * roomsPerPage + 1;
    const endIndex = Math.min(startIndex + roomsPerPage - 1, 110);

    // Create an array to store promises for each AJAX request
    const promises = [];

    // Iterate over the rooms within the current page range
    for (let roomNumber = startIndex; roomNumber <= endIndex; roomNumber++) {
        // Push the promise of the AJAX request to the array
        promises.push(
            $.ajax({
                url: `../includes/getRoomData.php?roomNumber=${roomNumber}&building=${building}`,
                type: 'GET',
                dataType: 'json'
            })
        );
    }

    // Use Promise.all() to wait for all promises to resolve
    Promise.all(promises)
        .then(dataArray => {
            // Iterate over the received data and update the table
            dataArray.forEach((data, index) => {
                const roomNumber = startIndex + index;
                const row = `
                    <tr>
                        <td>${roomNumber}</td>
                        ${getStudentColumns(data)}
                        <td>${data.length}</td>
                    </tr>
                `;
                $('#data-table tbody').append(row);
            });

            // Update the pagination links
            updatePagination();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


// Function to generate HTML for student columns
function getStudentColumns(data) {
    let columnsHTML = '';

    // Iterate over the students in the room
    for (let i = 1; i <= 4; i++) {
        const student = data[i - 1]; // Get the i-th student

        // Check if there is a student for the current column
        if (student) {
            // Add the student column
            columnsHTML += `
                <td>
                    ${student.name}
                </td>
            `;
        } else {
            // No student for the current column, display "-"
            columnsHTML += '<td>-</td>';
        }
    }

    return columnsHTML;
}

// Function to update the table when the filter changes
function updateTable() {
    const building = currentBuilding;

    // Call the displayData function to update the table
    displayData(building);
}

// Initialize the table when the page loads
$(document).ready(function () {
    // Attach the updateTable function to the filter change event
    $('#filter').change(updateTable);

    // Call the displayData function with default values (building: boys)
    displayData('boys');
});

// Function to update the pagination links
function updatePagination() {
    // Remove existing pagination links
    $('.pagination').empty();

    // Calculate the total number of pages
    const totalPages = Math.ceil(110 / roomsPerPage);

    // Add pagination links for each page
    for (let page = 1; page <= totalPages; page++) {
        const liClass = page === currentPage ? 'active' : '';
        $('.pagination').append(`<li class="${liClass}"><a href="#" onclick="changePage(${page})">${page}</a></li>`);
    }
}


// Function to change the current page
function changePage(newPage) {
    currentPage = newPage;
    updateTable();
}
