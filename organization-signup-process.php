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
  echo "Organization Name: " . $orgName;

  // Determine the table name based on the organization name
  $tableName = "table_" . str_replace(' ', '_', $orgName);

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
    header("Location: dashboard.php");
    exit();
  } else {
    // User not found, display error message
    echo "Invalid username or password.";
  }

  // Close the prepared statement and database connection
  $stmt->close();
  $conn->close();
}
