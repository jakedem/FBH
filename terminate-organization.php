<?php
// Include the external database connection script
include 'db-connect.php';

// Retrieve orgId from the POST request
$orgId = isset($_POST['orgId']) ? intval($_POST['orgId']) : 0;

// Function to drop tables if they exist
function dropTableIfExists($conn, $tableName)
{
  $sql = "DROP TABLE IF EXISTS $tableName";
  return $conn->query($sql);
}

// Delete records from admins table where orgId matches
$sql = "DELETE FROM admins WHERE orgId = $orgId";
if ($conn->query($sql) === FALSE) {
  echo "Error deleting from admins table: " . $conn->error;
  $conn->close();
  exit();
}

// Retrieve organization name
$sql = "SELECT orgName FROM Organizations WHERE orgId = $orgId";
$result = $conn->query($sql);
$orgName = '';
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $orgName = $row['orgName'];
}

// Drop feedback table
$feedbackTableName = str_replace(' ', '_', $orgName) . "_" . $orgId . "_fb";
if (!dropTableIfExists($conn, $feedbackTableName)) {
  echo "Error dropping feedback table $feedbackTableName: " . $conn->error;
  $conn->close();
  exit();
}

// Drop user table
$tableName = str_replace(' ', '_', $orgName) . "_$orgId";
if (!dropTableIfExists($conn, $tableName)) {
  echo "Error dropping user table $tableName: " . $conn->error;
  $conn->close();
  exit();
}

// Delete records from Organizations table where orgId matches
$sql = "DELETE FROM Organizations WHERE orgId = $orgId";
if ($conn->query($sql) === FALSE) {
  echo "Error deleting from Organizations table: " . $conn->error;
}

// Close connection
$conn->close();
