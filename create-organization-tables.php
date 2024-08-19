<?php
// Include the external database connection script
include 'db-connect.php';

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
    $tableName = str_replace(' ', '_', $orgName) . "_$orgId";
    // Generate SQL query to create the user table
    $sqlCreateUserTable = "CREATE TABLE IF NOT EXISTS $tableName (
              userId INT AUTO_INCREMENT PRIMARY KEY,
              fullName VARCHAR(255) NOT NULL,
              email VARCHAR(255) NOT NULL,
              password VARCHAR(255) NOT NULL,
              orgId INT,
              FOREIGN KEY (orgId) REFERENCES Organizations(orgId)
          )";
    // Execute the SQL query to create the user table
    if ($conn->query($sqlCreateUserTable) === TRUE) {
      // Generate feedback table name
      $feedbackTableName = str_replace(' ', '_', $orgName) . "_" . $orgId . "_fb";
      // Generate SQL query to create the feedback table
      $sqlCreateFeedbackTable = "CREATE TABLE IF NOT EXISTS $feedbackTableName (
                feedbackId INT AUTO_INCREMENT PRIMARY KEY,
                userId INT NOT NULL,
                feedbackType VARCHAR(255) NOT NULL,
                feedbackText TEXT NOT NULL,
                anonymity BOOLEAN NOT NULL DEFAULT 0,
                submissionTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                orgId INT NOT NULL,
                FOREIGN KEY (userId) REFERENCES $tableName(userId),
                FOREIGN KEY (orgId) REFERENCES Organizations(orgId)
            )";

      // Execute the SQL query to create the feedback table
      if ($conn->query($sqlCreateFeedbackTable) === TRUE) {
        // Store the success message
        $successMessage = "Organization Schema created successfully";
      } else {
        // Handle error if feedback table creation fails
        $errorMessage = "Error creating feedback table: " . $conn->error;
        // You can choose to handle this error differently if needed
        echo $errorMessage;
      }
    } else {
      // Handle error if user table creation fails
      $errorMessage = "Error creating user table: " . $conn->error;
      // You can choose to handle this error differently if needed
      echo $errorMessage;
    }
  }
  // Output the success message after the loop
  echo $successMessage;
} else {
  echo "No organizations found with approval status not null or empty";
}
