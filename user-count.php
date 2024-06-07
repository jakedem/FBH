<?php
session_start();

// Check if the orgId is set in the session
if (!isset($_SESSION['orgId'])) {
  // If not, return an error message
  echo json_encode(array("error" => "Organization ID not found in session"));
  exit();
}

$orgId = $_SESSION['orgId'];

// Your database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fbh";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  // If connection fails, return an error message
  echo json_encode(array("error" => "Connection failed: " . $conn->connect_error));
  exit();
}

// Initialize user count
$userCount = 0;

// Get list of tables in the database
$tablesQuery = "SHOW TABLES";
$tablesResult = $conn->query($tablesQuery);

// Check if query was successful
if ($tablesResult) {
  // Iterate through the tables
  while ($row = $tablesResult->fetch_row()) {
    $tableName = $row[0];

    // Check if table name matches the format orgName_orgId
    if (preg_match('/^(.+)_(\d+)$/', $tableName, $matches)) {
      $tableOrgId = $matches[2];

      // Check if orgId matches the one in the session
      if ($tableOrgId == $orgId) {
        // Query to count users in the table
        $countQuery = "SELECT COUNT(*) AS userCount FROM $tableName";
        $result = $conn->query($countQuery);

        // Check if query was successful
        if ($result) {
          // Fetch the user count and add it to the total count
          $row = $result->fetch_assoc();
          $userCount += $row['userCount'];
        }
      }
    }
  }

  // Return user count as JSON response
  echo json_encode(array("userCount" => $userCount));
} else {
  // If query fails, return an error message
  echo json_encode(array("error" => "Error fetching table list: " . $conn->error));
}

// Close database connection
$conn->close();
