function loadExterneResults() {
  $.ajax({
    type: "GET",
    url: "../includes/demandeInternatExterne.php",
    success: function (response) {
      $("#searchResults").html(response);
    },
    error: function (xhr, status, error) {
      console.error("AJAX request failed: " + error);
    },
  });
}

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

// Call loadAllResults() when the page is loaded initially
$(document).ready(function () {
  loadExterneResults();
  loadCasaResults();
});

// Function to handle search when the user types in the search box
function searchExterne() {
  var input = document.getElementById("searchExterne").value;
  if (input.trim() === "") {
    // If the search box is empty, load all results
    loadExterneResults();
  } else {
    // If the search box is not empty, perform search
    $.ajax({
      type: "GET",
      url: "../includes/demandeInternatSearch.php",
      data: {
        input: input,
      },
      success: function (response) {
        $("#searchResults").html(response);
      },
      error: function (xhr, status, error) {
        console.error("AJAX request failed: " + error);
      },
    });
  }
}

function searchCasa() {
  var input = document.getElementById("searchCasa").value;
  if (input.trim() === "") {
    // If the search box is empty, load all results
    loadCasaResults();
  } else {
    // If the search box is not empty, perform search
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
