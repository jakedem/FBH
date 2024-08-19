<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Include the external database connection script
  include 'db-connect.php';

  // Retrieve organization name and ID from the form submission
  $orgName = isset($_POST['orgName']) ? strtolower($_POST['orgName']) : 'organization';
  $orgId = isset($_POST['orgId']) ? $_POST['orgId'] : '';

  // Retrieve user details from the form
  $email = $_POST['username'];
  $password = $_POST['password'];

  // Determine the table name based on the organization name and ID
  $tableName = str_replace(' ', '_', $orgName) . "_$orgId";

  // Check if the user exists in the organization's table
  $sql = "SELECT userId, fullName FROM $tableName WHERE email = ? AND password = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  // Prepare response array
  $response = array();

  // Check if the user was found
  if ($result->num_rows == 1) {
    // User found, fetch user data
    $user = $result->fetch_assoc();
    $fullName = $user['fullName'];
    $userId = $user['userId'];

    // Store the user's name, ID, orgName, and orgId in the session
    $_SESSION['userName'] = $fullName;
    $_SESSION['userId'] = $userId;
    $_SESSION['orgName'] = $orgName;
    $_SESSION['orgId'] = $orgId;

    // Set success response
    $response['status'] = 'success';
  } else {
    // User not found, set error response
    $response['status'] = 'error';
    $response['message'] = 'Invalid username or password.';
  }

  // Close the prepared statement and database connection
  $stmt->close();
  $conn->close();

  // Return JSON response
  echo json_encode($response);
}
