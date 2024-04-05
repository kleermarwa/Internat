function setPhaseTo2() {
  $.ajax({
    type: "POST",
    url: "../includes/set_setting.php",
    data: {
      phase: 2
    },
    success: function (response) {
      location.reload();
    },
    error: function (xhr, status, error) {
      console.error("AJAX request failed: " + error);
    }
  });
}
function setPhaseTo1() {
  $.ajax({
    type: "POST",
    url: "../includes/set_setting.php",
    data: {
      phase: 1
    },
    success: function (response) {
      location.reload();
    },
    error: function (xhr, status, error) {
      console.error("AJAX request failed: " + error);
    }
  });
}
$(document).ready(function () {
  var pollingInterval = 2000; // Polling interval in milliseconds
  var intervalId; // Variable to store the interval ID

  function loadCasaResults() {
    $.ajax({
      type: "GET",
      url: "../includes/demandeInternatCasa.php",
      data: {
        action: 'load',
      },
      success: function (response) {
        $("#casaResults").html(response);
      },
      error: function (xhr, status, error) {
        console.error("AJAX request failed: " + error);
      },
    });
  }

  // Function to start polling
  function startPolling() {
    intervalId = setInterval(loadCasaResults, pollingInterval);
  }

  // Function to stop polling
  function stopPolling() {
    clearInterval(intervalId);
  }

  // Initial load and start polling
  loadCasaResults();
  startPolling();

  // Function to handle search input
  $("#searchCasa").on("input", function () {
    var input = $(this).val();
    if (input.trim() === "") {
      startPolling();
      loadCasaResults();
    } else {
      stopPolling();
      searchCasa();
    }
  });

  // Function to perform search
  function searchCasa() {
    var input = $("#searchCasa").val();
    if (input.trim() !== "") {
      $.ajax({
        type: "GET",
        url: "../includes/demandeInternatCasa.php",
        data: {
          input: input,
          action: 'search',
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
});
