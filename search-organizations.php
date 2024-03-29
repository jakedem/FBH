<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "fbh";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$connection) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Check if the search query parameter is set
if (isset($_GET['searchQuery'])) {
  // Get the search query from the request
  $searchQuery = $_GET['searchQuery'];

  // Sanitize the search query to prevent SQL injection
  $sanitizedSearchQuery = mysqli_real_escape_string($connection, $searchQuery);

  // Construct the SQL query to search for organizations
  $sql = "SELECT orgName FROM organizations WHERE orgName LIKE '%$sanitizedSearchQuery%'";

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
      echo "<button class='edit'>View</button>";
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