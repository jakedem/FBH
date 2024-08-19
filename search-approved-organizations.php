<?php
// Include the external database connection script
include 'db-connect.php';

// Check if the search query parameter is set
if (isset($_GET['searchQuery'])) {
  // Get the search query from the request
  $searchQuery = $_GET['searchQuery'];

  // Sanitize the search query to prevent SQL injection
  $sanitizedSearchQuery = mysqli_real_escape_string($connection, $searchQuery);

  // Construct the SQL query to search for organizations
  $sql = "SELECT orgId, orgName FROM organizations WHERE orgName LIKE '%$sanitizedSearchQuery%' AND approval_status IS NOT NULL AND approval_status != ''";

  // Execute the SQL query
  $result = mysqli_query($connection, $sql);

  // Check if there are any results
  if ($result && mysqli_num_rows($result) > 0) {
    // Output data of each row in a table structure
    echo "<table>";
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row["orgName"] . "</td>";
      echo "<td>";
      echo "<button class='view' data-org-id='" . $row["orgId"] . "'>View</button>";
      echo "<button class='terminate'>Terminate</button>";
      echo "</td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    // If no results found, echo a message
    echo "No organizations found";
  }
} else {
  // If the search query parameter is not set, return an error message or handle it as per your application logic
  echo "Error: Search query parameter is missing.";
}

// Close the database connection
mysqli_close($connection);

// Modal structure with CSS styles
echo <<<HTML
<link rel="stylesheet" type="text/css" href="./styles/modal.css">

<div id="organizationModal" class="modal">
  <div class="modal-content">
    <span id="closeModal" class="close">&times;</span>
    <h2>Organization Details</h2>
    <p><strong>Organization ID:</strong> <span id="modalOrgId"></span></p>
    <p><strong>Name:</strong> <span id="modalOrgName"></span></p>
    <p><strong>Type:</strong> <span id="modalOrgType"></span></p>
    <p><strong>Address:</strong> <span id="modalAddress"></span></p>
    <h3>Admin Details</h3>
    <p><strong>Admin ID:</strong> <span id="modalAdminId"></span></p>
    <p><strong>Admin Name:</strong> <span id="modalAdminName"></span></p>
    <p><strong>Admin Email:</strong> <span id="modalAdminEmail"></span></p>
  </div>
</div>
HTML;
