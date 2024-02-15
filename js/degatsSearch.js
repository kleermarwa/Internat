function loadAllResults() {
    $.ajax({
      type: "GET",
      url: "../admin/degatsDisplay.php",
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
  
    // var pollingInterval = 5000;
  
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
        url: "../admin/degatsSearch.php",
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
  