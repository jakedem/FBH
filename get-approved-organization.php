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

// SQL query to fetch organizations with "Approved" status
$sql = "SELECT * FROM organizations WHERE approval_status = 'Approved'";

$result = $conn->query($sql);

// Check if there are any organizations
if ($result->num_rows > 0) {
  // Output data of each row
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["orgName"] . "</td>";
    echo "<td>";
    echo "<button class='view' data-org-id='" . $row["orgId"] . "'>View</button>";
    echo "<button class='terminate'>Terminate</button>";
    echo "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='2'>No organizations found</td></tr>";
}

// Close connection
$conn->close();


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
