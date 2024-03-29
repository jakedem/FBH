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

// Check if orgId is provided in the URL
if (isset($_GET['orgId'])) {
  $orgId = $_GET['orgId'];

  // Prepare SQL statement to fetch organization details
  $stmt = $conn->prepare("SELECT orgId, orgName, orgType, address FROM Organizations WHERE orgId = ?");
  $stmt->bind_param("i", $orgId);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if organization details are found
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Store organization details in an associative array
    $orgDetails = array(
      'orgId' => $row['orgId'],
      'orgName' => $row['orgName'],
      'orgType' => $row['orgType'],
      'address' => $row['address']
    );

    // Return organization details as JSON
    header('Content-Type: application/json');
    echo json_encode($orgDetails);
  } else {
    echo "Organization not found.";
  }

  // Close prepared statement
  $stmt->close();
} else {
  echo "Organization ID not provided.";
}

// Close connection
$conn->close();
