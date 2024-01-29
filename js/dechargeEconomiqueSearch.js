function loadAllResults() {
  $.ajax({
    type: "GET",
    url: "../includes/allDechargeEconomique.php",
    success: function (response) {
      $("#searchResults").html(response);
    },
    error: function (xhr, status, error) {
      console.error("AJAX request failed: " + error);
    },
  });
}

$(document).ready(function () {
  loadAllResults();
});

function search() {
  var input = document.getElementById("searchBox").value;
  if (input.trim() === "") {    
    loadAllResults();
  } else {    
    $.ajax({
      type: "GET",
      url: "../includes/dechargeEconomiqueSearch.php",
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
