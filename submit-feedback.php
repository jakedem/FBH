<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['userName'])) {
  // If not, redirect to the login page
  header("Location: organization-login.php");
  exit();
}

$userName = $_SESSION['userName'];
$orgName = isset($_SESSION['orgName']) ? $_SESSION['orgName'] : 'Organization'; // Retrieve organization name from session
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Feedback Hub 360 - Submit Feedback</title>
  <link rel="stylesheet" href="styles/submit-feedback.css" />
  <link rel="stylesheet" href="./styles/index.css" />
</head>

<body>
  <div class="title-text">Feedback Submission</div>
  <div class="container">
    <form id="feedbackForm" action="submit-feedback-form.php" method="POST">
      <select name="feedbackType" id="feedbackType">
        <option value="General">General Feedback</option>
        <option value="Complaints">Complaints</option>
        <option value="Suggestions">Suggestions</option>
        <option value="Facilities">Facilities and Infrastructure</option>
        <option value="Safety">Safety and Security</option>
      </select>
      <textarea name="feedbackText" id="feedbackText" rows="5" placeholder="Enter your feedback here"></textarea>
      <button type="submit">Submit</button>
    </form>
  </div>
</body>

</html>