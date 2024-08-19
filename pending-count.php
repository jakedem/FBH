<?php
session_start();

// Check if the admin is logged in and the orgId is set in the session
if (!isset($_SESSION['orgId'])) {
  // If not, return an error message
  echo json_encode(array("error" => "Organization ID not found in session"));
  exit();
}

// Include the external database connection script
include 'db-connect.php';

// Prepare SQL statement to select the count of organizations with an empty approval_status
$sql = "SELECT COUNT(*) AS pendingCount FROM organizations WHERE approval_status IS NULL OR approval_status = ''";

// Execute SQL query
$result = $conn->query($sql);

// Check if query was successful
if ($result) {
  // Fetch the result as an associative array
  $row = $result->fetch_assoc();
  $pendingCount = $row['pendingCount'];

  // Return the count as JSON response
  echo json_encode(array("pendingCount" => $pendingCount));
} else {
  // If query fails, return an error message
  echo json_encode(array("error" => "Error fetching pending count: " . $conn->error));
}

// Close database connection
$conn->close();
