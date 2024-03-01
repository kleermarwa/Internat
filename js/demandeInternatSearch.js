// function loadExterneResults() {
//   $.ajax({
//     type: "GET",
//     url: "../includes/demandeInternatExterne.php",
//     success: function (response) {
//       $("#searchResults").html(response);
//     },
//     error: function (xhr, status, error) {
//       console.error("AJAX request failed: " + error);
//     },
//   });
// }

function loadCasaResults() {
  $.ajax({
    type: "GET",
    url: "../includes/demandeInternatCasa.php",
    success: function (response) {
      $("#casaResults").html(response);
    },
    error: function (xhr, status, error) {
      console.error("AJAX request failed: " + error);
    },
  });
}

$(document).ready(function () {
  // loadExterneResults();
  loadCasaResults();
});

// function searchExterne() {
//   var input = document.getElementById("searchExterne").value;
//   if (input.trim() === "") {
//     loadExterneResults();
//   } else {
//     $.ajax({
//       type: "GET",
//       url: "../includes/demandeInternatSearch.php",
//       data: {
//         input: input,
//       },
//       success: function (response) {
//         $("#searchResults").html(response);
//       },
//       error: function (xhr, status, error) {
//         console.error("AJAX request failed: " + error);
//       },
//     });
//   }
// }
// function searchExterneRoom() {
//   var inputRoom = document.getElementById("searchExterneRoom").value;
//   if (inputRoom.trim() === "") {
//     loadExterneResults();
//   } else {
//     $.ajax({
//       type: "GET",
//       url: "../includes/demandeInternatSearch.php",
//       data: {
//         inputRoom: inputRoom,
//       },
//       success: function (response) {
//         $("#searchResults").html(response);
//       },
//       error: function (xhr, status, error) {
//         console.error("AJAX request failed: " + error);
//       },
//     });
//   }
// }

function searchCasa() {
  var input = document.getElementById("searchCasa").value;
  if (input.trim() === "") {
    loadCasaResults();
  } else {
    $.ajax({
      type: "GET",
      url: "../includes/demandeInternatCasaSearch.php",
      data: {
        input: input,
      },
      success: function (response) {
        $("#casaResults").html(response);
      },
      error: function (xhr, status, error) {
        console.error("AJAX request failed: " + error);
      },
    });
  }
}
function searchCasaRoom() {
  var inputRoom = document.getElementById("searchCasaRoom").value;
  if (inputRoom.trim() === "") {
    loadCasaResults();
  } else {
    $.ajax({
      type: "GET",
      url: "../includes/demandeInternatCasaSearch.php",
      data: {
        inputRoom: inputRoom,
      },
      success: function (response) {
        $("#casaResults").html(response);
      },
      error: function (xhr, status, error) {
        console.error("AJAX request failed: " + error);
      },
    });
  }
}
