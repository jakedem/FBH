<?php
$orgName = isset($_GET['orgName']) ? $_GET['orgName'] : 'Organization';
$orgId = isset($_GET['orgId']) ? $_GET['orgId'] : ''; // Retrieve orgId from the URL
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In - <?php echo $orgName; ?></title>
  <link rel="stylesheet" href="./styles/organization-authentication.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <header>
    <!-- link to go back to home to be added later -->
  </header>

  <main>
    <div class="login-container">
      <h2><?php echo $orgName . $orgId; ?> User Login</h2>
      <form id='login-form' action="organization-login-process.php" method="post">
        <!-- Include the organization name and orgId as hidden input fields -->
        <input type="hidden" name="orgName" value="<?php echo $orgName; ?>">
        <input type="hidden" name="orgId" value="<?php echo $orgId; ?>">
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
      Switch to <a href="organization-admin-login.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">Admin Login</a>
    </div>
    <br>
    <hr>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> Feedback Hub360</p>
  </footer>

  <script>
    document.getElementById('login-form').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent the form from submitting the traditional way

      var formData = new FormData(this);

      fetch(this.action, {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(result => {
          if (result.status === 'success') {
            window.location.href = 'organization-user.php';
          } else {
            Swal.fire({
              title: 'Error!',
              text: result.message,
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }
        })
        .catch(error => {
          Swal.fire({
            title: 'Error!',
            text: 'There was an issue with your request.',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        });
    });
  </script>

</body>

</html>