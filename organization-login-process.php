<?php
session_start(); // Start the session

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
  $orgId = isset($_POST['orgId']) ? $_POST['orgId'] : '';

  // Retrieve user details from the form
  $email = $_POST['username'];
  $password = $_POST['password'];

  // Determine the table name based on the organization name and ID
  $tableName = str_replace(' ', '_', $orgName) . "_$orgId";

  // Check if the user exists in the organization's table
  $sql = "SELECT userId, fullname FROM $tableName WHERE email = ? AND password = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if the user was found
  if ($result->num_rows == 1) {
    // User found, fetch user data
    $user = $result->fetch_assoc();
    $fullname = $user['fullname'];
    $userId = $user['userId'];

    // Store the user's name, ID, orgName, and orgId in the session
    $_SESSION['userName'] = $fullname;
    $_SESSION['userId'] = $userId;
    $_SESSION['orgName'] = $orgName;
    $_SESSION['orgId'] = $orgId;

    // Redirect to the user dashboard
    header("Location: organization-user.php");
    exit();
  } else {
    // User not found, display error message
    echo "Invalid username or password.";
  }

  // Close the prepared statement and database connection
  $stmt->close();
  $conn->close();
}
