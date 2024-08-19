<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Include the external database connection script
  include 'db-connect.php';

  // Retrieve form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];

  // Basic validation
  if ($password !== $confirmPassword) {
    echo 'Passwords do not match.';
    exit();
  }

  // Check if email already exists
  $sql = "SELECT email FROM sadminsignup WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    echo 'Email already exists.';
    $stmt->close();
    $conn->close();
    exit();
  }

  // Insert new user into the database
  $sql = "INSERT INTO sadminsignup (name, email, password, confirmpassword) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $name, $email, $password, $confirmPassword);

  if ($stmt->execute()) {
    echo 'success';
  } else {
    echo 'There was an issue creating your account.';
  }

  // Close connections
  $stmt->close();
  $conn->close();
} else {
  // Redirect back to signup page if the form is not submitted
  header("Location: sadmin-signup.html");
  exit();
}
