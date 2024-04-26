<?php
$orgName = isset($_GET['orgName']) ? $_GET['orgName'] : 'Organization';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In - <?php echo $orgName; ?></title>
  <link rel="stylesheet" href="./styles/organization-authentication.css">
</head>

<body>
  <header>
    <!-- link to go  back to home to be added later -->
  </header>

  <main>
    <div class="login-container">
      <h2><?php echo $orgName; ?> User Login</h2>
      <form action="login_process.php" method="post">
        <label for="username">Email:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <input type="submit" value="Login">
      </form>
      <br>
      <a href="forgot_password.php">Forgot Password?</a><br>
      <br>
      Switch to <a href="organization-admin-login.php?orgName=<?php echo urlencode($orgName); ?>">Admin Login</a>
    </div>
    <br>
    <hr>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> Your Organization</p>
  </footer>
</body>

</html>