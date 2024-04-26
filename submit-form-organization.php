<?php
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

  // Assign form data to variables
  $orgName = $_POST["orgName"];
  $orgType = $_POST["orgType"];
  $address = $_POST["address"];
  $adminName = $_POST["adminName"];
  $adminEmail = $_POST["adminEmail"];
  $adminPassword = $_POST["adminPassword"];

  // Generate orgId starting from 00001
  $result = $conn->query("SELECT MAX(orgId) AS maxOrgId FROM Organizations");
  $row = $result->fetch_assoc();
  $maxOrgId = $row["maxOrgId"];
  if ($maxOrgId === NULL) {
    $orgId = "00001";
  } else {
    $orgId = str_pad((intval($maxOrgId) + 1), 5, "0", STR_PAD_LEFT);
  }

  // Prepare SQL statement to insert organization data
  $sqlOrg = "INSERT INTO Organizations (orgId, orgName, orgType, address) VALUES (?, ?, ?, ?)";
  $stmtOrg = $conn->prepare($sqlOrg);
  $stmtOrg->bind_param("ssss", $orgId, $orgName, $orgType, $address);

  // Prepare SQL statement to insert admin data
  $sqlAdmin = "INSERT INTO Admins (orgId, adminName, adminEmail, adminPassword) VALUES (?, ?, ?, ?)";
  $stmtAdmin = $conn->prepare($sqlAdmin);
  $stmtAdmin->bind_param("ssss", $orgId, $adminName, $adminEmail, $adminPassword);

  // Execute the prepared statements
  if ($stmtOrg->execute() && $stmtAdmin->execute()) {
    echo "New organization and admin added successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  // Close the prepared statements and database connection
  $stmtOrg->close();
  $stmtAdmin->close();
  $conn->close();
}
