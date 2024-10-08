<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>System Admin Dashboard</title>
  <link rel="stylesheet" href="./styles/index.css" />
  <link rel="stylesheet" href="./styles/sidebar.css" />
  <link rel="stylesheet" href="./styles/header.css" />
  <link rel="stylesheet" href="./styles/home.css" />
  <link rel="stylesheet" href="./styles/add-organization.css" />
  <link rel="stylesheet" href="./styles/manage-organization.css" />
  <link rel="sytlesheet" href="./styles/scan.css">
  </link>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="header">
    <img src="./icons/list.svg" alt="Menu Icon" class="menu-icon" />
    <h3 class="header-text">System Admin Dashboard</h3>
  </div>

  <div class="sidebar">
    <div class="side-links">
      <a href="#" onclick="loadHome()"><img src="./icons/home.svg" alt="Home Icon" class="icon" /> Home</a>
      <a href="#" onclick="loadAddOrganization()"><img src="./icons/addorganization.svg" alt="Organizations Icon" class="icon" />
        Add Organization</a>

      <a href="#" onclick="loadManageOrganization()"><img src="./icons/organization.svg" alt="Organizations Icon" class="icon" />
        Manage Organization</a>

      <a href="#" onclick="loadSendEmail()"><img src="./icons/mail.svg" alt="Admin Icon" class="icon" /> Send Email</a>

      <!-- <a href="#" onclick="loadManageSuperAdmin()"
          ><img
            src="./icons/superadmin.svg"
            alt="Super Admin Icon"
            class="icon"
          />
          Manage Super Admin</a
        > -->

      <a href="#" onclick="loadSystemSecurity()"><img src="./icons/security.svg" alt="Security Icon" class="icon" />
        Security & Monitoring</a>
      <a href="#" onclick="loadSystemSettings()"><img src="./icons/settings.svg" alt="Settings Icon" class="icon" />
        System Settings</a>
    </div>
    <button class="logout-button" onclick="logout()">Logout</button>
  </div>

  <main class="main-section"></main>

  <script src="script.js"></script>
</body>

</html>