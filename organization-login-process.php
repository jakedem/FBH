<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Database connection parameters
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

  // Retrieve organization name from the form submission
  $orgName = isset($_POST['orgName']) ? strtolower($_POST['orgName']) : 'organization';


  // Find the corresponding organization ID in the database
  $sql = "SELECT orgId FROM Organizations WHERE orgName = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $orgName);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if the SQL query was successful
  if (!$result) {
    die("Error executing SQL query: " . $conn->error);
  }

  // Check if any rows were returned
  if ($result->num_rows == 1) {
    // Fetch the row
    $row = $result->fetch_assoc();
    $orgId = $row['orgId'];

    // Determine the table name based on the organization name and ID
    $tableName = "table_" . str_replace(' ', '_', $orgName) . "_$orgId";

    // Retrieve user details from the form
    $email = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists in the organization's table
    $sql = "SELECT * FROM $tableName WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user was found
    if ($result->num_rows == 1) {
      // User found, do something (e.g., redirect to a dashboard)
      header("Location: https://www.google.com");
      exit();
    } else {
      // User not found, display error message
      echo "Invalid username or password.";
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
  } else {
    // Handle the case where organization ID retrieval fails
    echo "Organization not found or multiple organizations found with the same name.";
    exit();
  }
}
