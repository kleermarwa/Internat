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


$(document).ready(function () {
    loadAllResults();

    var pollingInterval = 2000;

    setInterval(function () {
        loadAllResults();
    }, pollingInterval);
});

function searchAll() {
    var input = document.getElementById("searchExterne").value;
    if (input.trim() === "") {
        loadAllResults();
    } else {
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


