<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "fbh";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

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
