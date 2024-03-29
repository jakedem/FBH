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

    // Store organization details in variables
    $orgId = $row['orgId'];
    $orgName = $row['orgName'];
    $orgType = $row['orgType'];
    $address = $row['address'];

    // Output organization details with styling
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Organization Details</title>";
    echo "<link rel='stylesheet' href='get-organization-details.css'>"; // Include the external CSS file
    echo "</head>";
    echo "<body>";
    echo "<div class='organization-details'>";
    echo "<h2>Organization Details</h2>";
    echo "<p><strong>Organization ID:</strong> $orgId</p>";
    echo "<p><strong>Name:</strong> $orgName</p>";
    echo "<p><strong>Type:</strong> $orgType</p>";
    echo "<p><strong>Address:</strong> $address</p>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
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
