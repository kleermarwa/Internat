<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boarding School Room Map</title>
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="select.css">
</head>

<body>
    <!-- Room map container -->
    <div id="roomMap"></div>

    <!-- Floor selection dropdown -->
    <form id="app-cover">
        <div id="select-box">
            <input type="checkbox" id="options-view-button">
            <div id="select-button" class="brd">
                <div id="selected-value">
                    <span>Select a floor</span>
                </div>
                <div id="chevrons">
                    <i class="fas fa-chevron-up"></i>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div id="options">
                <div class="option">
                    <input class="s-c top" type="radio" name="platform" value="1">
                    <input class="s-c bottom" type="radio" name="platform" value="1">
                    <i class="fas fa-solid fa-door-open"></i>
                    <span class="label">Ground floor</span>
                    <span class="opt-val">Ground floor</span>
                </div>
                <div class="option">
                    <input class="s-c top" type="radio" name="platform" value="2">
                    <input class="s-c bottom" type="radio" name="platform" value="2">
                    <i class="fa">1</i>
                    <span class="label">First Floor</span>
                    <span class="opt-val">First Floor</span>
                </div>
                <div class="option">
                    <input class="s-c top" type="radio" name="platform" value="3">
                    <input class="s-c bottom" type="radio" name="platform" value="3">
                    <i class="fa">2</i>
                    <span class="label">Second Floor</span>
                    <span class="opt-val">Second Floor</span>
                </div>
                <div class="option">
                    <input class="s-c top" type="radio" name="platform" value="4">
                    <input class="s-c bottom" type="radio" name="platform" value="4">
                    <i class="fa">3</i>
                    <span class="label">Third Floor</span>
                    <span class="opt-val">Third Floor</span>
                </div>
                <div class="option">
                    <input class="s-c top" type="radio" name="platform" value="5">
                    <input class="s-c bottom" type="radio" name="platform" value="5">
                    <i class="fa">4</i>
                    <span class="label">Fourth Floor</span>
                    <span class="opt-val">Fourth Floor</span>
                </div>
                <div id="option-bg"></div>
            </div>
        </div>
    </form>

    <div class="popup" id="popup">
        <p>Room Information</p>
        <p id="popupRoomNumber"></p>
        <div id="popupImages"></div>
    </div>

    <script>
        // Room data for each floor
        const floors = {
            1: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 1,
                type: 'room'
            })),
            2: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 23,
                type: 'room'
            })),
            3: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 45,
                type: 'room'
            })),
            4: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 67,
                type: 'room'
            })),
            5: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 89,
                type: 'room'
            })),
        };

        let currentFloor = 1; // Default to Ground Floor

        // Room dimensions and layout
        const roomWidth = 70;
        const roomHeight = 70;
        const spacing = 10;
        const numRows = 2;
        const numCols = 11;

        // Calculate total width and height
        const totalWidth = (numCols * roomWidth) + ((numCols - 1) * spacing) + 160;
        const totalHeight = (numRows * roomHeight) + ((numRows - 1) * spacing);

        // Create SVG container
        const svg = d3.select("#roomMap")
            .append("svg")
            .attr("width", totalWidth)
            .attr("height", totalHeight);

        // Draw building border
        svg.append("rect")
            .attr("class", "building")
            .attr("width", totalWidth)
            .attr("height", totalHeight);

        // Function to update room layout based on the selected floor
        function updateRoomLayout() {
            // Clear existing room groups
            svg.selectAll("g").remove();

            // Create rooms for the selected floor
            const roomGroups = svg.selectAll("g")
                .data(floors[currentFloor])
                .enter()
                .append("g")
                .attr("transform", (d, i) => {
                    const col = i % numCols;
                    const row = Math.floor(i / numCols);
                    const x = row % 2 === 0 ? col * (roomWidth + spacing) : (numCols - 1 - col) * (roomWidth + spacing);
                    const y = row * (roomHeight + spacing);
                    return `translate(${x}, ${y})`;
                });

            // Draw rooms
            roomGroups.append("rect")
                .attr("class", 'room')
                .attr("width", roomWidth)
                .attr("height", roomHeight)
                .attr("x", 100)
                .style("fill", d => getRoomColor(d.id)) // Assign color dynamically
                .on("click", showPopup);

            // Draw room numbers
            roomGroups.append("text")
                .attr("class", "roomNumber")
                .text(d => d.id)
                .attr("x", roomWidth / 2 + 100)
                .attr("y", roomHeight / 2)
                .attr("text-anchor", "middle")
                .attr("dominant-baseline", "middle");

            // Draw bathroom
            svg.append("rect")
                .attr("class", "bathroom")
                .attr("width", 80)
                .attr("height", totalHeight)
                .attr("x", 0); // Adjust the position based on room layout

            // Draw stairs
            svg.append("rect")
                .attr("class", "stairs")
                .attr("width", 50)
                .attr("height", totalHeight)
                .attr("x", totalWidth - 50); // Adjust the position based on room layout

            // Draw divider line
            svg.append("line")
                .attr("class", "divider")
                .attr("x1", roomWidth + 20)
                .attr("y1", 0)
                .attr("x2", roomWidth + 20)
                .attr("y2", totalHeight);
        }

        // Function to get the color based on the number of students in the room
        function getRoomColor(roomId) {
            const room = floors[currentFloor].find(room => room.id === roomId);

            if (!room || room.type !== 'room') {
                return '#b3b3b3'; // Default color for non-room elements
            }

            const numStudents = getNumStudentsInRoom(room.id);

            switch (numStudents) {
                case 0:
                    return '#1afa25';
                case 1:
                    return '#66ccff';
                case 2:
                    return 'yellow';
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
                url: 'getStudentsCount.php',
                type: 'POST',
                data: {
                    roomId: roomId
                },
                dataType: 'json',
                async: false, // Make the AJAX call synchronous to wait for the result
                success: function(response) {
                    if (response.success) {
                        numStudents = response.numStudents;
                    } else {
                        console.error('Failed to get students count:', response.message);
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });

            return numStudents;
        }

        // Initial room layout for the default floor
        updateRoomLayout();
        document.querySelectorAll('#options input[type="radio"]').forEach(function(radio) {
            radio.addEventListener('change', changeFloor);
        });

        // Function to handle floor change
        function changeFloor() {
            // Assuming you have a reference to the selected option element
            currentFloor = parseInt(document.querySelector('#options input[type="radio"]:checked').value);
            updateRoomLayout();
        }
        // Event listener for document click to close the dropdown
        document.addEventListener("click", function(event) {
            var dropdown = document.getElementById("options-view-button");
            var dropdownContainer = document.getElementById("options");

            // Check if the clicked element is not inside the dropdown or its container
            if (!dropdownContainer.contains(event.target) && event.target !== dropdown) {
                // Close the dropdown by unchecking the checkbox
                dropdown.checked = false;
            }
        });

        // Event listener for radio inputs to close the dropdown when a value is selected
        var radioInputs = document.querySelectorAll('#options input[type="radio"]');
        radioInputs.forEach(function(radioInput) {
            radioInput.addEventListener("change", function() {
                // Close the dropdown by unchecking the checkbox
                document.getElementById("options-view-button").checked = false;
            });
        });


        // Popup functionality
        function showPopup() {
            const roomNumber = d3.select(this).datum().id;
            const popup = document.getElementById("popup");
            const popupRoomNumber = document.getElementById("popupRoomNumber");
            const popupImages = document.getElementById("popupImages");

            // Fetch student data using AJAX
            $.ajax({
                url: `getRoomData.php?roomNumber=${roomNumber}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Set room number in popup
                    popupRoomNumber.textContent = `Room ${roomNumber}`;

                    // Set images and student info in popup
                    popupImages.innerHTML = "";

                    // Add student data to popup
                    data.forEach(student => {
                        // Check if the image field is empty, assign a default avatar
                        const imageUrl = student.image ? student.image : 'images/default_user.png';

                        popupImages.innerHTML += `
                    <div class="student-container">
                        <img src="${imageUrl}" alt="${student.name}">
                        <p>${student.name}</p>
                        <button onclick="showStudentInfo(${student.id})">More Info</button>
                    </div>
                `;
                    });

                    // Show the popup
                    popup.style.display = "block";

                    // Close the info popup when clicking outside
                    document.addEventListener("click", function closepopupOutside(event) {
                        if (!popup.contains(event.target)) {
                            popup.style.display = "none";
                            document.removeEventListener("click", closepopupOutside);
                        }
                    });

                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }

        // Function to show more information about a specific student
        function showStudentInfo(studentId) {
            // Fetch additional student info using AJAX
            $.ajax({
                url: `getStudentInfo.php?studentId=${studentId}`,
                type: 'GET',
                dataType: 'json',
                success: function(studentInfo) {
                    // Display additional information in a new popup
                    const infoPopup = document.createElement("div");
                    const imageUrl = studentInfo.image ? studentInfo.image : 'images/default_user.png';
                    infoPopup.className = "info-popup";

                    infoPopup.innerHTML = `
                <div class="card-overlay"></div>
                <div class="card-inner">
                <img src="${imageUrl}" alt="${studentInfo.name}">
                <p class='name'>${studentInfo.name}</p>
                <p>Email: ${studentInfo.email}</p>
                <p>Date of Birth: ${studentInfo.date_naissance}</p>
                <p>City: ${studentInfo.ville}</p>
                <p>Phone: ${studentInfo.tel}</p>
                <p>Field of Study: ${studentInfo.filliere}</p>
                <p>Academic Year: ${studentInfo.annee_scolaire}</p>
                <div class='btn'>;
                <button style='color:red' onclick="deleteStudent(${studentId})">Delete Student</button>
                <button style='color:blue' onclick="moveStudent(${studentId})">Move to Another Room</button>
                </div></div>
            `;

                    document.body.appendChild(infoPopup);

                    // Close the info popup when clicking outside
                    document.addEventListener("click", function closeInfoPopupOutside(event) {
                        if (!infoPopup.contains(event.target)) {
                            infoPopup.style.display = "none";
                            document.removeEventListener("click", closeInfoPopupOutside);
                        }
                    });
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }

        function deleteStudent(studentId) {
            // Show a confirmation dialog
            const confirmDelete = confirm('Are you sure you want to delete this student?');

            if (confirmDelete) {
                // Proceed with deletion
                $.ajax({
                    url: 'deleteStudent.php',
                    type: 'POST',
                    data: {
                        studentId: studentId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Student deleted successfully');
                            // Close the info popup
                            document.querySelector('.info-popup').style.display = 'none';
                        } else {
                            alert('Failed to delete student');
                        }
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            }
        }

        // Function to move a student to another room
        function moveStudent(studentId) {
            // Prompt the user for the new room number
            const newRoomNumber = prompt('Enter the new room number:');

            // Check if the input is valid
            if (newRoomNumber !== null && !isNaN(newRoomNumber) && newRoomNumber !== '') {
                // Send AJAX request to move student
                $.ajax({
                    url: 'moveStudent.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        studentId: studentId,
                        newRoomNumber: newRoomNumber
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Student moved successfully');
                            // Close the info popup
                            document.querySelector('.info-popup').style.display = 'none';
                        } else {
                            if (response.error === 'Invalid room number') {
                                alert('Invalid room number');
                            } else if (response.error === 'Room is already full') {
                                alert('Room is already full');
                            } else {
                                alert('Failed to move student');
                            }
                        }
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            } else {
                alert('Invalid room number');
            }
        }
        // Function to close the popup
        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>
</body>

</html>