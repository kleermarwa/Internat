<?php
// Include database connection and other necessary files
include '../includes/db_connect.php';

// Fetch unread notifications from the database
$sqlcount = "SELECT decharge.*, students.*
        FROM decharge
        JOIN students ON decharge.student_id = students.id
        WHERE decharge.valide_departement = 0
          AND decharge.notification_status = 'unread'
        ORDER BY decharge.created_at DESC";
$result = $conn->query($sqlcount);

$notifications = array();


if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $notifications[] = array(
      'id_demande' => $row['id_demande'],
      'message' => 'New decharge request from student ' . $row['name']
    );
  }

  // Mark fetched notifications as read
  $updateSql = "UPDATE decharge SET notification_status = 'read' WHERE notification_status = 'unread'";
  $conn->query($updateSql);
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($notifications);
