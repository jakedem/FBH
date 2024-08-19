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
  $anonymity = isset($_POST['anonymity']) ? 1 : 0;

  // Get user ID from session
  $userId = $_SESSION['userId'];

  // Database connection parameters
  include 'db-connect.php';

  // Construct SQL query to insert feedback into database table
  $feedbackTableName = str_replace(' ', '_', $orgName) . "_" . $orgId . "_fb";
  $sql = "INSERT INTO $feedbackTableName (userId, feedbackType, feedbackText, anonymity, orgId) VALUES (?, ?, ?, ?, ?)";

  // Prepare and bind parameters
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("issii", $userId, $feedbackType, $feedbackText, $anonymity, $orgId);

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
