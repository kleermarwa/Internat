function loadAllResults() {
  $.ajax({
    type: "GET",
    url: "../includes/allDechargeInternat.php",
    success: function (response) {
      $("#searchResults").html(response);
    },
    error: function (xhr, status, error) {
      console.error("AJAX request failed: " + error);
    },
  });
}

// Call loadAllResults() when the page is loaded initially
$(document).ready(function () {
  loadAllResults();
});

// Function to handle search when the user types in the search box
function search() {
  var input = document.getElementById("searchBox").value;
  if (input.trim() === "") {
    // If the search box is empty, load all results
    loadAllResults();
  } else {
    // If the search box is not empty, perform search
    $.ajax({
      type: "GET",
      url: "../includes/dechargeInternatSearch.php",
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
