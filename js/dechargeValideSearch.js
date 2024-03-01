function loadAllResults() {
  $.ajax({
    type: "GET",
    url: "../includes/allDechargeValides.php",
    data: {
      action: 'loadAdmin',
    },
    success: function (response) {
      $("#searchResults").html(response);
    },
    error: function (xhr, status, error) {
      console.error("AJAX request failed: " + error);
    },
  });
}
function loadAllResultsHistory() {
  $.ajax({
    type: "GET",
    url: "../includes/allDechargeValides.php",
    data: {
      action: 'loadInternat',
    },
    success: function (response) {
      $("#searchResultsHis").html(response);
    },
    error: function (xhr, status, error) {
      console.error("AJAX request failed: " + error);
    },
  });
}

$(document).ready(function () {
  loadAllResults();
  loadAllResultsHistory();

  // var pollingInterval = 2000;

  // setInterval(function () {
  //   loadAllResults();
  // }, pollingInterval);
});

function search() {
  var input = document.getElementById("searchBox").value;
  if (input.trim() === "") {
    loadAllResults();
  } else {
    $.ajax({
      type: "GET",
      url: "../includes/allDechargeValides.php",
      data: {
        input: input,
        action: 'searchAdmin'
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
function searchHis() {
  var input = document.getElementById("searchBox").value;
  if (input.trim() === "") {
    loadAllResults();
  } else {
    $.ajax({
      type: "GET",
      url: "../includes/allDechargeValides.php",
      data: {
        input: input,
        action: 'searchInternat'
      },
      success: function (response) {
        $("#searchResultsHis").html(response);
      },
      error: function (xhr, status, error) {
        console.error("AJAX request failed: " + error);
      },
    });
  }
}
