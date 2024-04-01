$(document).ready(function () {
    var pollingInterval = 200;
    var intervalId;

    function loadAllResults() {
        $.ajax({
            type: "GET",
            url: "../admin/internat_demandes_historique.php",
            data: {
                action: 'load',
            },
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
            url: "../admin/internat_demandes_historique.php",
            data: {
                input: input,
                action: 'search',
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
