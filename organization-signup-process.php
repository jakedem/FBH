
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Include the external database connection script
  include 'db-connect.php';

  // Retrieve form inputs
  $orgName = isset($_POST['orgName']) ? strtolower($_POST['orgName']) : 'organization';
  $orgId = isset($_POST['orgId']) ? $_POST['orgId'] : '';
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];

  // Validate password
  if (
    strlen($password) <= 8 ||
    !preg_match("#[0-9]+#", $password) ||
    !preg_match("#[^\w]+#", $password)
  ) {
    echo "Password must be more than 8 characters long, and include at least one number and one special character.";
    exit();
  }

  // Check if passwords match
  if ($password !== $confirmPassword) {
    echo "Passwords do not match.";
    exit();
  }

  // Find the corresponding organization ID in the database
  $sql = "SELECT orgId FROM Organizations WHERE orgName = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $orgName);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if the SQL query was successful
  if (!$result) {
    echo "Error executing SQL query: " . $conn->error;
    exit();
  }

  // Check if any rows were returned
  if ($result->num_rows == 1) {
    // Fetch the row
    $row = $result->fetch_assoc();
    $orgId = $row['orgId'];

    // Determine the table name based on the organization name and ID
    $tableName = str_replace(' ', '_', $orgName) . "_$orgId";

    // Insert user details into the respective organization's table, including orgId
    $sql = "INSERT INTO $tableName (fullname, email, password, orgId) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $fullname, $email, $password, $orgId);

    // Execute the prepared statement
    if ($stmt->execute()) {
      // Respond with a success message
      echo "success";
    } else {
      // Handle the case where insertion fails
      echo "Error executing SQL statement: " . $stmt->error;
    }
  } else {
    // Handle the case where organization ID retrieval fails
    echo "Organization not found or multiple organizations found with the same name.";
  }

  // Close the prepared statement and database connection
  $stmt->close();
  $conn->close();
}
