<?php
session_start();

if (!isset($_SESSION['orgId'])) {
  echo json_encode(array("error" => "Organization ID not found in session"));
  exit();
}

$orgName = isset($_SESSION['orgName']) ? $_SESSION['orgName'] : 'Organization';
$orgId = $_SESSION['orgId'];

// Include the external database connection script
include 'db-connect.php';

$feedbackTableName = str_replace(' ', '_', $orgName) . "_" . $orgId . "_fb";
$sql = "SELECT feedbackType, COUNT(*) as count FROM $feedbackTableName GROUP BY feedbackType";
$result = $conn->query($sql);

if ($result) {
  $feedbackTypes = array();
  $feedbackCounts = array();

  while ($row = $result->fetch_assoc()) {
    $feedbackTypes[] = $row['feedbackType'];
    $feedbackCounts[] = $row['count'];
  }

  echo json_encode(array("feedbackTypes" => $feedbackTypes, "feedbackCounts" => $feedbackCounts));
} else {
  echo json_encode(array("error" => "Error fetching feedback counts: " . $conn->error));
}

$conn->close();
