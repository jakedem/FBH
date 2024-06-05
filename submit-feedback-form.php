<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if user is logged in
  if (!isset($_SESSION['userName'])) {
    // If not logged in, redirect to login page
    header("Location: organization-login.php");
    exit();
  }

  // Retrieve organization name and ID from session
  $orgName = isset($_SESSION['orgName']) ? $_SESSION['orgName'] : 'Organization';
  $orgId = isset($_SESSION['orgId']) ? $_SESSION['orgId'] : '';

  // Retrieve feedback data from form submission
  $feedbackType = $_POST['feedbackType'];
  $feedbackText = $_POST['feedbackText'];

  // Get user ID from session
  $userId = $_SESSION['userId'];

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

  // Construct SQL query to insert feedback into database table
  $feedbackTableName = str_replace(' ', '_', $orgName) . "_" . $orgId . "_fb";
  $sql = "INSERT INTO $feedbackTableName (userId, feedbackType, feedbackText) VALUES (?, ?, ?)";

  // Prepare and bind parameters
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iss", $userId, $feedbackType, $feedbackText);

  // Execute the prepared statement
  if ($stmt->execute() === TRUE) {
    echo "Feedback submitted successfully.";
  } else {
    echo "Error submitting feedback: " . $conn->error;
  }

  // Close the prepared statement and database connection
  $stmt->close();
  $conn->close();
}
