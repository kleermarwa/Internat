function startDecharge() {
  $.ajax({
    type: "POST",
    url: "../includes/set_setting.php",
    data: {
      decharge: 2
    },
    success: function (response) {
      // location.reload();
    },
    error: function (xhr, status, error) {
      console.error("AJAX request failed: " + error);
    }
  });
}
function stopDecharge() {
  $.ajax({
    type: "POST",
    url: "../includes/set_setting.php",
    data: {
      decharge: 1
    },
    success: function (response) {
      // location.reload();
    },
    error: function (xhr, status, error) {
      console.error("AJAX request failed: " + error);
    }
  });
}
$(document).ready(function () {
  var pollingInterval = 2000; // Polling interval in milliseconds
  var intervalId; // Variable to store the interval ID

  // Function to load all results
  function loadAllResults() {
    $.ajax({
      type: "GET",
      url: "../admin/decharge_display.php",
      data: {
        action: 'load'
      },
      success: function (response) {
        $("#searchResults").html(response);
      },
      error: function (xhr, status, error) {
        console.error("AJAX request failed: " + error);
      },
    });
  }

  // Function to start polling
  function startPolling() {
    intervalId = setInterval(loadAllResults, pollingInterval);
  }

  // Function to stop polling
  function stopPolling() {
    clearInterval(intervalId);
  }

  // Initial load and start polling
  loadAllResults();
  startPolling();

  // Function to handle search input
  $("#searchBox").on("input", function () {
    var input = $(this).val();
    if (input.trim() === "") {
      startPolling();
      loadAllResults();
    } else {
      stopPolling();
      search(input);
    }
  });

  // Function to perform search
  function search(input) {
    $.ajax({
      type: "GET",
      url: "../admin/decharge_display.php",
      data: {
        input: input,
        action: 'search'
      },
      success: function (response) {
        $("#searchResults").html(response);
      },
      error: function (xhr, status, error) {
        console.error("AJAX request failed: " + error);
      },
    });
  }
});
