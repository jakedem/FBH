<?php
// Your database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fbh";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve organizations with approval status not null or empty
$sql = "SELECT orgId, orgName FROM Organizations WHERE approval_status IS NOT NULL AND approval_status != ''";
$result = $conn->query($sql);

// Check if any organization with approval status not null or empty exists
if ($result->num_rows > 0) {
  $successMessage = ""; // Initialize an empty string for success message
  // Loop through each organization
  while ($row = $result->fetch_assoc()) {
    $orgId = $row["orgId"];
    $orgName = $row["orgName"];
    // Generate table name for the organization
    $tableName = "table_" . str_replace(' ', '_', $orgName) . "_$orgId";
    // Generate SQL query to create the table
    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS $tableName (
              userId INT AUTO_INCREMENT PRIMARY KEY,
              fullName VARCHAR(255) NOT NULL,
              email VARCHAR(255) NOT NULL,
              password VARCHAR(255) NOT NULL,
              orgId INT,
              FOREIGN KEY (orgId) REFERENCES Organizations(orgId)
          )";
    // Execute the SQL query to create the table
    if ($conn->query($sqlCreateTable) === TRUE) {
      // Store the success message
      $successMessage = "Tables created successfully";
    } else {
      // Handle error if table creation fails
      $errorMessage = "Error creating table: " . $conn->error;
      // You can choose to handle this error differently if needed
      echo $errorMessage;
    }
  }
  // Output the success message after the loop
  echo $successMessage;
} else {
  echo "No organizations found with approval status not null or empty";
}
