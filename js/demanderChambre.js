function demanderChambre(roomNumber, id, name, gender, ville) {
  // Prepare data to be sent to PHP
  var data = {
    roomNumber: roomNumber,
    id: id,
    name: name,
    gender: gender,
    ville: ville,
  };

  // Send AJAX request using jQuery
  $.ajax({
    url: "../includes/demanderChambre.php",
    type: "POST",
    data: data,
    dataType: "json", // Expect JSON response
    success: function (response) {
      // Check the response for success or error
      if (response.success) {
        // Display success message
        showSuccessMessage(response.message);
      } else {
        // Display error message
        showErrorMessage(response.message);
      }
    },
    error: function (error) {
      console.error("There was a problem with the AJAX request:", error);
      // Display error message
      showErrorMessage("Error making the request");
    },
  });
}

// Function to display success message
function showSuccessMessage(message) {
  // Add success message to the page
  $('<div class="success">' + message + '</div>').appendTo('body').fadeIn(300).delay(3000).fadeOut(400);
}

// Function to display error message
function showErrorMessage(message) {
  // Add error message to the page
  $('<div class="error">' + message + '</div>').appendTo('body').fadeIn(300).delay(3000).fadeOut(400);
}
