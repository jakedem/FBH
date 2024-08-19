<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Organization Landing Page</title>
  <link rel="stylesheet" href="styles/360.css">
</head>

<body class="light-grey-background">
  <?php
  // Check if organization name and ID are provided
  $orgName = isset($_GET['orgName']) ? $_GET['orgName'] : 'Organization';
  $orgId = isset($_GET['orgId']) ? $_GET['orgId'] : '';
  // Display welcome message with organization name
  // echo "<h1 class='centered-org-name'>{$orgName}</h1>";
  ?>
  <header class="full-width-header">
    <nav>
      <ul class="nav-links">
        <li class="logo">
          <span class="white-text">Feedback</span>
          <span class="red-text">Hub360</span>
        </li>

        <li><a href="about.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">About</a></li>
        <li><a href="contact.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">Contact</a></li>
        <li><a href="organization-signup.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">Sign Up</a></li>
        <li><a href="organization-login.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">Log In</a></li>
      </ul>
    </nav>
  </header>

  <main class="light-grey-background">

    <?php
    // Check if organization name and ID are provided
    // $orgName = isset($_GET['orgName']) ? $_GET['orgName'] : 'Organization';
    // $orgId = isset($_GET['orgId']) ? $_GET['orgId'] : '';
    // Display welcome message with organization name
    echo "<h1 class='centered-org-name'>{$orgName}</h1>";
    ?>

    <div class="content-container">
      <!-- First Row -->
      <div class="text-column">
        <h2 class="large-text special-font">Elevate Your</h2>
        <h2 class="large-text blue-text special-font">Feedback</h2>
        <h2 class="large-text special-font">With Our App</h2>
      </div>
      <div class="image-column">
        <!-- Placeholder for Text Image -->

      </div>

      <!-- Second Row -->
      <div class="read-more-column special-font">
        <p>Unlock valuable insights and drive</p>
        <p>continuous improvement with our</p>
        <p>intuitive feedback app</p>
      </div>
      <div class="login-column">
        <p class="admin-text">Administrator Please Login in here</p>
        <br><a href="organization-admin-login.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">Admin Login</a>
      </div>
    </div>
  </main>

  <footer>
    <p class="center-text">&copy; <?php echo date("Y"); ?> Feedback Hub360</p>
  </footer>
</body>

</html>