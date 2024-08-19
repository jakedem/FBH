<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Include the external database connection script
  include 'db-connect.php';

  // Retrieve form data
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Prepare SQL statement to select admin from the sadminsignup table
  $sql = "SELECT email, password FROM sadminsignup WHERE email = ? AND password = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 1) {
    // Login successful
    echo 'success';
  } else {
    // Login failed
    echo 'Invalid email or password.';
  }

  // Close connections
  $stmt->close();
  $conn->close();
} else {
  // Redirect back to login page if the form is not submitted
  header("Location: sadmin-login.html");
  exit();
}
