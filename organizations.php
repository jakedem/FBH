<?php
// Connect to your database
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

// Query to get the organization names with non-empty approval_status
$sql = "SELECT * FROM organizations WHERE approval_status IS NOT NULL AND approval_status != ''";
$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Organizations</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <h2>Organizations</h2>
  <div class="container">
    <div class="organizations">
      <?php
      // Check if there are any organizations
      if ($result->num_rows > 0) {
        // Initialize counter
        $counter = 1;
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
          // Check if 'adminid' key exists
          $adminid = isset($row['adminid']) ? $row['adminid'] : ''; // Default value if key is undefined

          // Generate link for each organization name with numbering
          echo "<div>{$counter}. <a href='organization-details.php?orgName={$row['orgName']}&address={$row['address']}&adminid={$adminid}'>{$row['orgName']}</a></div>";
          // Increment counter
          $counter++;
        }
      } else {
        echo "0 results";
      }
      ?>
    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>