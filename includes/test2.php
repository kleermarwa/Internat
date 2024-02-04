<?php
include 'db_connect.php';

$user_id = 1;
$selectQuery = "SELECT * FROM decharge WHERE student_id = ?";
$selectStmt = $conn->prepare($selectQuery);
$selectStmt->bind_param('i', $user_id);
$selectStmt->execute();
$result = $selectStmt->get_result();

while ($row = $result->fetch_assoc()) {
  $creationDate = new DateTime(date('Y') . '-04-01');
  $januaryFirst = new DateTime(date('Y') . '-01-01');

  $diff = $creationDate->diff($januaryFirst);
  $days = $diff->days;

  $halfMonths = ceil($days / 15);

  $accommodationFee = $halfMonths * 50; 
  $restaurationFee = $halfMonths * 75; 
  $totalFee = $accommodationFee + $restaurationFee;

  echo date('Y') . '-04-01';
  echo "<p>Logement: $accommodationFee dh</p>";
  echo "<p>Restauration : $restaurationFee dh</p>";
  echo "<p>Total : $totalFee dh</p>";
}
