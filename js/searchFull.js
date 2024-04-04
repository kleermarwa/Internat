$(document).ready(function () {
  var $searchBox = $("#search");
  var $searchResults = $("#search-results");

  $searchBox.keyup(function () {
    var search_term = $(this).val();

    if (search_term.trim() !== "") {
      $.ajax({
        url: `../includes/searchFull.php?term=${search_term}`,
        type: "GET",
        dataType: "json",
        success: function (data) {
          var results = "";
          if (data.length > 0) {
            $.each(data, function (index, student) {
              if (student.status === "interne") {
                results +=
                  '<div class="search-result" onclick="showPopupStudent(' +
                  student.roomNumber +
                  ')">';
                results += '<img src="' + student.image + '" width="50">';
                results += "<div> <span>" + student.label + "</span><br>";
                results +=
                  '<span> Status: <span style="color:green; text-transform: capitalize;">' +
                  student.status +
                  "</span></span><br>";
                results +=
                  "<span> Chambre: " + student.roomNumber + "</span> </div>";
                results += "</div>";
              } else {
                results +=
                  '<div class="search-result" onclick="showStudentInfo(' +
                  student.id +
                  ')" >';
                results += '<img src="' + student.image + '" width="50">';
                results += "<div> <span>" + student.label + "</span><br>";
                results +=
                  '<span> Status: <span style="color:red; text-transform: capitalize;">' +
                  student.status +
                  "</span></span> </div> <br>";
                results += "</div>";
              }
            });
            $searchResults.html(results).show();
          } else {
            results += '<div class="search-result">';
            results += "<p>Aucun Résultat trouvé</p>";
            results += "</div>";
            $searchResults.html(results).show();
          }
        },
      });
    } else {
      $searchResults.hide();
    }
  });

  $(document).click(function (event) {
    if (
      !$(event.target).is($searchBox) &&
      !$(event.target).is($searchResults)
    ) {
      $searchResults.hide();
      $("#search").val("");
    }
  });
});

$(document).ready(function () {
  "use strict";

  $("#search, .fa-search").mouseenter(function () {
    $(".logo").hide();
  });

  $("#search, .fa-search").mouseleave(function () {
    $(".logo").show();
  });

  $(".fa-bars").click(function () {
    $(".navbar").toggle();
    $(this).toggleClass("fa-times");
  });

  $(".navbar, .navbar a").click(function () {
    $(".navbar").hide();
    $(".fa-bars").removeClass("fa-times");
  });
});
