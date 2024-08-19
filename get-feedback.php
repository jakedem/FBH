<?php
session_start();

// Check if the organization ID is set in the session
if (!isset($_SESSION['orgId'])) {
  // If not, return an error message
  echo json_encode(array("error" => "Organization ID not found in session"));
  exit();
}

// Retrieve organization name and ID from session
$orgName = isset($_SESSION['orgName']) ? $_SESSION['orgName'] : 'Organization';
$orgId = $_SESSION['orgId'];

// Include the external database connection script
include 'db-connect.php';

// Construct SQL query to select basic feedback details from dynamic feedback table
$feedbackTableName = str_replace(' ', '_', $orgName) . "_" . $orgId . "_fb";
$sql = "SELECT feedbackId, feedbackType, feedbackText, submissionTime, anonymity FROM $feedbackTableName";

// Execute SQL query
$result = $conn->query($sql);

// Check if query was successful
if ($result) {
  // Initialize an empty string to store HTML table rows
  $feedbackDetailsHTML = "";

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Details</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="./styles/feedback-table.css">
    <!-- <link rel="stylesheet" href="./styles/manage-organization.css"> -->
  </head>

  <body>
    <div class="title-text">Feedback</div>
    <div class="feedback-table-container">
      <table class="feedback-table">
        <thead>
          <tr>
            <th>Number</th>
            <th>Type</th>
            <th>Text</th>
            <th>Submission Time</th>
            <th>Anonymity</th>
          </tr>
        </thead>
        <tbody id="feedback-details-body">
          <?php
          // Check if there are any feedbacks
          if ($result->num_rows > 0) {
            // Initialize counter
            $counter = 1;
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
              // Format the submission time
              $submissionTime = date("F j, Y, g:i a", strtotime($row['submissionTime']));
              // Output each feedback as a table row
              echo "<tr>";
              echo "<td>{$counter}</td>"; // Number column
              echo "<td>{$row['feedbackType']}</td>"; // Type column
              echo "<td>{$row['feedbackText']}</td>"; // Text column
              echo "<td>{$submissionTime}</td>"; // Submission time column
              echo "<td>{$row['anonymity']}</td>"; // Anonymity column
              echo "</tr>";
              // Increment counter
              $counter++;
            }
          } else {
            echo "<tr><td colspan='5'>No feedbacks found</td></tr>"; // Colspan set to 5 to span all columns
          }
          ?>
        </tbody>
      </table>
    </div>
  </body>

  </html>
<?php

} else {
  // If query fails, return an error message
  echo json_encode(array("error" => "Error fetching feedback details: " . $conn->error));
}

// Close database connection
$conn->close();
?>