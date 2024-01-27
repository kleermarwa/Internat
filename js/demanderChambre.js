function demanderChambre(roomNumber, id, name, gender, ville) {
  // Assuming you are using AJAX to send data to the PHP file
  // You can use XMLHttpRequest or fetch API for AJAX requests

  // Prepare data to be sent to PHP
  var data = new FormData();
  data.append("roomNumber", roomNumber);
  data.append("id", id);
  data.append("name", name);
  data.append("gender", gender);
  data.append("ville", ville);
  // Send AJAX request
  fetch("../includes/demanderChambre.php", {
    method: "POST",
    body: data,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.text();
    })
    .then((data) => {
      // Handle response from PHP if necessary
      console.log(data);
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
}
