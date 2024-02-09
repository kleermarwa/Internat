<?php
session_start();

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
  http_response_code(403);
  exit('<div style="text-align: center; width: max-content; margin: 2rem auto 0 auto; border: 1px solid;">
  <h1 style="font-weight: 900;">Forbidden</h1>
  <h4 style="font-weight: 600;"> <strong>Error 403: </strong>You don\'t have permission to access this resource.</h4>
  <h2 style="font-weight: 600; color:red;">⬇⬇ 7esslek A7sen 2 sikiriti ⬇⬇</h2>
  <img style="width: 17rem; height: 17rem; margin : 1rem;" src="../images/lklb.jpeg" alt="">
  <img style="width: 17rem; height: 17rem; margin : 1rem;" src="../images/moulchi.jpeg" alt="">
  <hr>
  Direct access not allowed. This endpoint is intended for AJAX requests only.
</div>');
}

include '../includes/db_connect.php';
$sqlcount = "SELECT decharge.*, users.*
    FROM decharge
    JOIN users ON decharge.student_id = users.id";

$updateSql = "UPDATE decharge ";

if (isset($_SESSION['role'])) {
  switch ($_SESSION['role']) {
    case 'departement':
      $sqlcount .= " WHERE decharge.read_departement = 0 AND decharge.valide_departement = 0";
      $updateSql .= "SET decharge.read_departement = 1 WHERE decharge.read_departement = 0";
      break;
    case 'internat':
      $sqlcount .= " WHERE decharge.read_internat = 0 AND decharge.valide_departement = 1 AND decharge.valide_internat = 0";
      $updateSql .= "SET decharge.read_internat = 1 WHERE decharge.read_internat = 0 AND decharge.valide_departement = 1";
      break;
    case 'economique':
      $sqlcount .= " WHERE decharge.read_economique = 0 AND decharge.valide_departement = 1 AND decharge.valide_internat = 1 AND decharge.valide_economique = 0";
      $updateSql .= "SET decharge.read_economique = 1 WHERE decharge.read_economique = 0 AND decharge.valide_internat = 1";
      break;
    case 'administration':
      $sqlcount .= " WHERE decharge.read_administartion = 0 AND decharge.valide_departement = 1 AND decharge.valide_internat = 1 AND decharge.valide_economique = 1 AND decharge.valide_administration = 0";
      $updateSql .= "SET decharge.read_administartion = 1 WHERE decharge.read_administartion = 0 AND decharge.valide_economique = 1";
      break;
  }
}

$sqlcount .= " ORDER BY decharge.created_at DESC";

$result = $conn->query($sqlcount);
$notifications = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $notifications[] = array(
      'id_demande' => $row['id_demande'],
      'message' => 'New decharge request from student ' . $row['name']
    );
  }

  $conn->query($updateSql);
}

header('Content-Type: application/json');
echo json_encode($notifications);
