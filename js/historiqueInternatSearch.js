$(document).ready(function () {
    var pollingInterval = 2000;
    var intervalId;

    function loadAllResults() {
        $.ajax({
            type: "GET",
            url: "../admin/internat_demandes_historique.php",
            success: function (response) {
                $("#searchResults").html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX request failed: " + error);
            },
        });
    }

    function startPolling() {
        intervalId = setInterval(loadAllResults, pollingInterval);
    }

    function stopPolling() {
        clearInterval(intervalId);
    }

    loadAllResults();
    startPolling();

    $("#searchExterne").on("input", function () {
        var input = $(this).val();
        if (input.trim() === "") {
            startPolling();
            loadAllResults();
        } else {
            stopPolling();
            searchAll();
        }
    });
});

function searchAll() {
    var input = $("#searchExterne").val();
    if (input.trim() !== "") {
        $.ajax({
            type: "GET",
            url: "../includes/historiqueInternatSearch.php",
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
