<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Include the external database connection script
  include 'db-connect.php';

  // Retrieve username and password from the form
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Retrieve organization name and ID from the form
  $orgName = $_POST["orgName"];
  $orgId = $_POST["orgId"];

  // Store organization name and ID in the session
  $_SESSION['orgName'] = $orgName;
  $_SESSION['orgId'] = $orgId;

  // Prepare SQL statement to select admin from database
  $sql = "SELECT adminName FROM Admins WHERE adminEmail = ? AND adminPassword = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $username, $password);

  // Execute the prepared statement
  $stmt->execute();

  // Store the result
  $result = $stmt->get_result();

  // Check if there is a row with matching credentials
  if ($result->num_rows == 1) {
    // Fetch the admin name
    $row = $result->fetch_assoc();
    $adminName = $row['adminName'];

    // Store the admin's name in the session
    $_SESSION['adminName'] = $adminName;

    // Respond with success
    echo json_encode(['status' => 'success', 'message' => 'Login successful']);
  } else {
    // Respond with an error
    echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
  }

  // Close the prepared statement and database connection
  $stmt->close();
  $conn->close();
} else {
  // Redirect if form is not submitted
  header("Location: organization-admin-login.php");
  exit();
}
