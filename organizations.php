<?php
// Include the external database connection script
include 'db-connect.php';

// Query to get the organization names with non-empty approval_status
$sql = "SELECT * FROM organizations WHERE approval_status IS NOT NULL AND approval_status != ''";
$result = $conn->query($sql);

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
  <div class='title-text'>Organizations </div>
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
            // Generate the URL for the organization's landing page
            $url = "360.php?orgName={$row['orgName']}&orgId={$row['orgId']}";

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