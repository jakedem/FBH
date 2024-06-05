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

  // Retrieve username and password from the form
  $username = $_POST["username"];
  $password = $_POST["password"];

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

    // Redirect the user to the admin dashboard if login is successful
    header("Location: organization-admin-dashboard.php");
    exit(); // Stop further execution
  } else {
    // Redirect the user back to the login page with an error message
    header("Location: organization-admin-login.php?error=login_failed");
    exit(); // Stop further execution
  }

  // Close the prepared statement and database connection
  $stmt->close();
  $conn->close();
} else {
  // Redirect the user back to the login page if form is not submitted
  header("Location: organization-admin-login.php");
  exit(); // Stop further execution
}
