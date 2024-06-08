<?php
session_start(); // Start the session

// Check if the admin is logged in
if (!isset($_SESSION['adminName'])) {
  // If not, redirect to the login page
  header("Location: organization-admin-login.php");
  exit();
}

$adminName = $_SESSION['adminName'];
$orgName = $_SESSION['orgName'];
$orgId = $_SESSION['orgId'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="./styles/index.css" />
  <link rel="stylesheet" href="./styles/sidebar.css" />
  <link rel="stylesheet" href="./styles/header.css" />
  <link rel="stylesheet" href="./styles/home.css" />
  <link rel="stylesheet" href="./styles/add-organization.css" />
  <link rel="stylesheet" href="./styles/manage-organization.css" />
  <link rel="stylesheet" href="./styles/barchart.css">
  <style>
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      background-color: #f4f4f4;
      color: black;
    }

    .header-text {
      margin: 0;
    }

    .admin-info {
      display: flex;
      align-items: center;
    }

    .admin-name,
    .org-info {
      margin-right: 20px;
      color: black;
    }

    .admin-name {
      font-size: 1rem;
      color: #333;
    }

    @media (max-width: 768px) {
      .header {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>

<body>
  <div class="header">
    <div style="display: flex; align-items: center;">
      <img src="./icons/list.svg" alt="Menu Icon" class="menu-icon" />
      <h3 class="header-text">Admin Dashboard</h3>
    </div>

    <div class="admin-info">
      <div class="org-info">Organization: <?php echo htmlspecialchars($orgName); ?> (ID: <?php echo htmlspecialchars($orgId); ?>)</div>
      <div class="admin-name"><?php echo htmlspecialchars($adminName); ?></div>
    </div>
  </div>

  <div class="sidebar">
    <div class="side-links">
      <a href="#" onclick="loadHome()">
        <img src="./icons/home.svg" alt="Home Icon" class="icon" /> Home
      </a>
      <a href="#" onclick="loadFeedback()">
        <img src="./icons/addorganization.svg" alt="Organizations Icon" class="icon" />
        Feedback Overview
      </a>
      <a href="#" onclick="loadUsers()">
        <img src="./icons/organization.svg" alt="Organizations Icon" class="icon" />
        User Management
      </a>
      <!-- <a href="#" onclick="loadSystemSecurity()">
        <img src="./icons/security.svg" alt="Security Icon" class="icon" />
        Security & Monitoring
      </a> -->
      <a href="#" onclick="loadSystemSettings()">
        <img src="./icons/settings.svg" alt="Settings Icon" class="icon" />
        System Settings
      </a>
    </div>
    <button class="logout-button" onclick="logout()">Logout</button>
  </div>

  <main class="main-section"></main>

  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
  <script src="script-org.js"></script>
</body>

</html>