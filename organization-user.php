<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['userName'])) {
  // If not, redirect to the login page
  header("Location: organization-login.php");
  exit();
}

$userName = $_SESSION['userName'];
$orgName = isset($_SESSION['orgName']) ? $_SESSION['orgName'] : 'Organization';
$orgId = isset($_SESSION['orgId']) ? $_SESSION['orgId'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="./styles/index.css">
  <link rel="stylesheet" href="./styles/sidebar.css">
  <link rel="stylesheet" href="./styles/header.css">
  <link rel="stylesheet" href="./styles/user-dashboard.css">
</head>

<body>
  <div class="header">
    <img src="./icons/list.svg" alt="Menu Icon" class="menu-icon" />
    <h3 class="header-text"><?php echo htmlspecialchars($userName); ?>'s Dashboard - <?php echo htmlspecialchars($orgName); ?> (ID: <?php echo htmlspecialchars($orgId); ?>)</h3>
  </div>

  <div class="sidebar">
    <div class="side-links">
      <a href="#" onclick="loadHome()"><img src="./icons/home.svg" alt="Home Icon" class="icon" /> Home</a>
      <a href="#" onclick="loadSubmitFeedback()"><img src="./icons/addorganization.svg" alt="Organizations Icon" class="icon" /> Submit Feedback</a>
      <a href="#" onclick="loadManageOrganization()"><img src="./icons/organization.svg" alt="Organizations Icon" class="icon" /> Feedback History</a>
      <a href="#" onclick="loadSystemSettings()"><img src="./icons/settings.svg" alt="Settings Icon" class="icon" /> System Settings</a>
    </div>
    <button class="logout-button" onclick="logout()">Logout</button>
  </div>

  <main class="main-section"></main>

  <script src="script-user.js"></script>
</body>

</html>