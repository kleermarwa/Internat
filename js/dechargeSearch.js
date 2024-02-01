function loadAllResults() {
  $.ajax({
    type: "GET",
    url: "../admin/decharge_display.php",
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
      url: "../admin/decharge_search.php",
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
