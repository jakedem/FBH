<?php
header('Content-Type: application/json');

// Include the external database connection script
include 'db-connect.php';

// Performance Scan: Identify slow queries, table sizes, and index usage
$slowQueries = [];
$tableSizes = [];
$indexUsage = [];

// Slow Queries
$result = $conn->query("SHOW FULL PROCESSLIST");
while ($row = $result->fetch_assoc()) {
  if ($row['Time'] > 1) { // Queries running for more than 1 second
    $slowQueries[] = $row;
  }
}

// Table Sizes
$result = $conn->query("SELECT table_name AS `Table`, 
       ROUND(((data_length + index_length) / 1024 / 1024), 2) `Size (MB)` 
       FROM information_schema.TABLES 
       WHERE table_schema = '$dbname'");
while ($row = $result->fetch_assoc()) {
  $tableSizes[] = $row;
}

// Index Usage
$result = $conn->query("SELECT table_name, 
       non_unique, index_name, seq_in_index, column_name 
       FROM information_schema.STATISTICS 
       WHERE table_schema = '$dbname'");
while ($row = $result->fetch_assoc()) {
  $indexUsage[] = $row;
}

// Security Scan: Find short passwords (less than 6 characters) in the admins table
$passwordVulnerabilities = [];

$result = $conn->query("SELECT * FROM admins WHERE LENGTH(adminPassword) < 6");
while ($row = $result->fetch_assoc()) {
  $passwordVulnerabilities[] = $row;
}

// Prepare JSON response
$response = [
  'slowQueries' => count($slowQueries) > 0 ? $slowQueries : 'No slow queries found',
  'tableSizes' => $tableSizes,
  'indexUsage' => $indexUsage,
  'passwordVulnerabilities' => count($passwordVulnerabilities) > 0 ? $passwordVulnerabilities : 'No password vulnerabilities found'
];

echo json_encode($response);

$conn->close();
