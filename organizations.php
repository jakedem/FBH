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
  <link rel="stylesheet" href="./styles/index.css" />
  <link rel="stylesheet" href="./styles/organizations.css" />
</head>

<body>
  <div class='title-text'>Organizations</div>
  <div class="container">
    <table class="organizations-table">
      <thead>
        <tr>
          <th>Number</th>
          <th>Organization Name</th>
          <th>Link</th> <!-- New column for the link -->
        </tr>
      </thead>
      <tbody>
        <?php
        // Check if there are any organizations
        if ($result->num_rows > 0) {
          // Initialize counter
          $counter = 1;
          // Output data of each row
          while ($row = $result->fetch_assoc()) {
            // Check if 'adminid' key exists
            $adminid = isset($row['adminid']) ? $row['adminid'] : ''; // Default value if key is undefined

            // Generate the URL for the organization's landing page
            $url = "organization-landing-page.php?orgName={$row['orgName']}&address={$row['address']}&adminid={$adminid}";

            // Output each organization as a table row
            echo "<tr>";
            echo "<td>{$counter}</td>"; // Number column
            echo "<td>{$row['orgName']}</td>"; // Name column
            echo "<td><a href='{$url}'>{$url}</a></td>"; // Link column with the generated hyperlink
            echo "</tr>";
            // Increment counter
            $counter++;
          }
        } else {
          echo "<tr><td colspan='3'>0 results</td></tr>"; // Colspan set to 3 to span all columns
        }
        ?>
      </tbody>
    </table>
  </div>
  <script src="script.js"></script>
</body>

</html>