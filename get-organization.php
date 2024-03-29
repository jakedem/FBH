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

// Check the filter value
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Fetch organization data from the database based on the filter value
if ($filter === 'all') {
  $sql = "SELECT orgId, orgName FROM Organizations";
} elseif ($filter === 'education') {
  $sql = "SELECT orgId, orgName FROM Organizations WHERE orgType = 'education'";
} elseif ($filter === 'business') {
  $sql = "SELECT orgId, orgName FROM Organizations WHERE orgType = 'business'";
} else {
  echo "Invalid filter value";
}

$result = $conn->query($sql);

// Check if any organizations are found
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
