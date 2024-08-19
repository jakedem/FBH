<?php

// Include the external database connection script
include 'db-connect.php';


// Get the organization ID from the POST request
$orgId = isset($_POST['orgId']) ? $_POST['orgId'] : '';

// Update the database
$sql = "UPDATE organizations SET approval_status = 'Approved' WHERE orgId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $orgId);

if ($stmt->execute()) {
  echo "Organization approved successfully!";
} else {
  echo "Error approving organization: " . $conn->error;
}

// Close connection
$stmt->close();
$conn->close();
