<?php
session_start();

// Check if the organization ID is set in the session
if (!isset($_SESSION['orgId'])) {
  // If not, return an error message
  echo json_encode(array("error" => "Organization ID not found in session"));
  exit();
}

// Retrieve organization name and ID from session
$orgName = isset($_SESSION['orgName']) ? $_SESSION['orgName'] : 'Organization';
$orgId = $_SESSION['orgId'];

// Include the external database connection script
include 'db-connect.php';
// Construct SQL query to select basic user details from organization's user table
$userTableName = $orgName . "_" . $orgId;
$sql = "SELECT userId, fullName, email FROM $userTableName";

// Execute SQL query
$result = $conn->query($sql);

// Check if query was successful
if ($result) {
  // Initialize an empty string to store HTML table rows
  $userDetailsHTML = "";

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="./styles/feedback-table.css">
    <link rel="stylesheet" href="./styles/manage-organization.css" />
    <link rel="stylesheet" href="./styles/index.css" />
    <link rel="stylesheet" href="./styles/header.css" />
  </head>

  <body>
    <div class="title-text">Users</div>
    <div class="manage-organization-container">
      <div class="options">
        <input type="text" placeholder="Search User" />
        <button id="searchButton"><img src="./icons/search.svg" alt="Search" /></button>
      </div>
      <div class="feedback-table-container">
        <table class="feedback-table">
          <thead>
            <tr>
              <th>Number</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="user-details-body">
            <?php
            // Check if there are any users
            if ($result->num_rows > 0) {
              // Initialize counter
              $counter = 1;
              // Output data of each row
              while ($row = $result->fetch_assoc()) {
                // Output each user as a table row
                echo "<tr>";
                echo "<td>{$counter}</td>"; // Number column
                echo "<td>{$row['fullName']}</td>"; // Full Name column
                echo "<td>{$row['email']}</td>"; // Email column
                echo "<td><button class='remove-btn' data-user-id='{$row['userId']}'>Remove</button></td>"; // Action column with Remove button
                echo "</tr>";
                // Increment counter
                $counter++;
              }
            } else {
              echo "<tr><td colspan='4'>No users found</td></tr>"; // Colspan set to 3 to span all columns
            }
            ?>
          </tbody>
        </table>
      </div>
  </body>

  </html>
<?php

} else {
  // If query fails, return an error message
  echo json_encode(array("error" => "Error fetching user details: " . $conn->error));
}

// Close database connection
$conn->close();
?>