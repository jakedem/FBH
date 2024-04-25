<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Organization Details</title>
  <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file here -->
</head>

<body>
  <header>
    <h1>Organization Details</h1>
  </header>

  <nav>
    <!-- Your navigation links go here -->
    <ul>
      <li><a href="home.php">Home</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="contact.php">Contact</a></li>
    </ul>
  </nav>

  <main>
    <section>
      <h2>Organization Information</h2>
      <p><strong>Name:</strong> <?php echo isset($_GET['orgName']) ? $_GET['orgName'] : 'N/A'; ?></p>
      <p><strong>Address:</strong> <?php echo isset($_GET['address']) ? $_GET['address'] : 'N/A'; ?></p>
    </section>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> Your Organization</p>
  </footer>
</body>

</html>