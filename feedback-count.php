<?php
session_start();

// Check if the admin is logged in and the orgId is set in the session
if (!isset($_SESSION['orgId'])) {
  // If not, return an error message
  echo json_encode(array("error" => "Organization ID not found in session"));
  exit();
}

$orgId = $_SESSION['orgId'];

// Include the external database connection script
include 'db-connect.php';

// Prepare SQL statement to select feedback count from dynamic feedback table
$tableName = str_replace(' ', '_', $_SESSION['orgName']) . "_$orgId" . "_fb";
$sql = "SELECT COUNT(*) AS feedbackCount FROM $tableName";

// Execute SQL query
$result = $conn->query($sql);

// Check if query was successful
if ($result) {
  // Fetch the result as an associative array
  $row = $result->fetch_assoc();
  $feedbackCount = $row['feedbackCount'];

  // Return feedback count as JSON response
  echo json_encode(array("feedbackCount" => $feedbackCount));
} else {
  // If query fails, return an error message
  echo json_encode(array("error" => "Error fetching feedback count: " . $conn->error));
}

// Close database connection
$conn->close();
