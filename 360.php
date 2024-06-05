<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Organization Landing Page</title>
  <link rel="stylesheet" href="./styles/organization-landing-page.css">
</head>

<body>
  <header>
    <?php
    // Check if organization name and ID are provided
    $orgName = isset($_GET['orgName']) ? $_GET['orgName'] : 'Organization';
    $orgId = isset($_GET['orgId']) ? $_GET['orgId'] : '';
    // Display welcome message with organization name
    echo "<h1>Welcome {$orgName} to Feedback Hub 360</h1>";
    ?>
    <!-- Echo Organization Name and ID -->
    <p>Organization Name: <?php echo $orgName; ?></p>
    <p>Organization ID: <?php echo $orgId; ?></p>
    <nav>
      <!-- Your navigation links go here -->
      <ul>
        <li><a href="home.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">Home</a></li>
        <li><a href="about.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">About</a></li>
        <li><a href="contact.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">Contact</a></li>
        <li><a href="organization-signup.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">Sign Up</a></li>
        <li><a href="organization-login.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">Log In</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div class="content">
      <h2>About Feedback Hub 360</h2>
      <p>Welcome to Feedback Hub 360, where feedback meets innovation!</p>
      <p>At Feedback Hub 360, we understand the importance of listening to your customers, employees, and stakeholders. That's why we've created a powerful platform to help you collect, manage, and act on feedback effectively.</p>
      <p>Our platform empowers organizations of all sizes to:</p>
      <p>Collect feedback through customizable surveys and forms</p>
      <p>Analyze feedback data in real-time with advanced reporting and analytics</p>
      <p>Engage with customers and employees to foster meaningful interactions</p>
      <p>Take actionable steps to improve products, services, and processes based on valuable insights</p>
      <p>Whether you're looking to enhance customer satisfaction, improve employee engagement, or innovate your products and services, Feedback Hub 360 provides the tools and insights you need to succeed.</p>
      <p>Join us on this journey of feedback-driven growth and innovation!</p>
    </div>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> Feedback Hub360</p>
  </footer>
</body>

</html>