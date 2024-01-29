function demanderChambre(roomNumber, id, name, gender, ville) {  
  var data = {
    roomNumber: roomNumber,
    id: id,
    name: name,
    gender: gender,
    ville: ville,
  };
  
  $.ajax({
    url: "../includes/demanderChambre.php",
    type: "POST",
    data: data,
  dataType: "json", 
    success: function (response) {      
      if (response.success) {        
        showSuccessMessage(response.message);
      } else {        
        showErrorMessage(response.message);
      }
    },
    error: function (error) {
      console.error("There was a problem with the AJAX request:", error);      
      showErrorMessage("Error making the request");
    },
  });
}

function showSuccessMessage(message) {  
  $('<div class="success">' + message + '</div>').appendTo('body').fadeIn(300).delay(3000).fadeOut(400);
}

function showErrorMessage(message) {  
  $('<div class="error">' + message + '</div>').appendTo('body').fadeIn(300).delay(3000).fadeOut(400);
}
