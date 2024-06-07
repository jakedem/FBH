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
    $tableName = str_replace(' ', '_', $orgName) . "_$orgId";

    // Retrieve user details from the form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Insert user details into the respective organization's table, including orgId
    $sql = "INSERT INTO $tableName (fullname, email, password, orgId) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $fullname, $email, $password, $orgId);

    // Execute the prepared statement
    if ($stmt->execute()) {
      // Close the prepared statement and database connection
      $stmt->close();
      $conn->close();

      // Redirect the user to a success page
      header("Location: success.php");
      exit();
    } else {
      // Handle the case where insertion fails
      echo "Error executing SQL statement: " . $stmt->error;
    }
  } else {
    // Handle the case where organization ID retrieval fails
    echo "Organization not found or multiple organizations found with the same name.";
    exit();
  }

  // Close the prepared statement and database connection
  $stmt->close();
  $conn->close();
}
