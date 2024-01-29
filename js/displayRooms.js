const roomsPerPage = 22;
let currentPage = 1;

function displayData(building) {
    $('#data-table tbody').empty();

    const startIndex = (currentPage - 1) * roomsPerPage + 1;
    const endIndex = Math.min(startIndex + roomsPerPage - 1, 110);

    // Create an array to store promises for each AJAX request
    const promises = [];

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

            updatePagination();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


function getStudentColumns(data) {
    let columnsHTML = '';

    for (let i = 1; i <= 4; i++) {
        const student = data[i - 1]; 
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

function updateTable() {
    const building = currentBuilding;
    displayData(building);
}

$(document).ready(function () {
    $('#filter').change(updateTable);
    displayData('boys');
});

// Function to update the pagination links
function updatePagination() {
    $('.pagination').empty();
    const totalPages = Math.ceil(110 / roomsPerPage);
    for (let page = 1; page <= totalPages; page++) {
        const liClass = page === currentPage ? 'active' : '';
        $('.pagination').append(`<li class="${liClass}"><a href="#" onclick="changePage(${page})">${page}</a></li>`);
    }
}

function changePage(newPage) {
    currentPage = newPage;
    updateTable();
}
