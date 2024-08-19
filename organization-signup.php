<?php
$orgName = isset($_GET['orgName']) ? $_GET['orgName'] : 'Organization';
$orgId = isset($_GET['orgId']) ? $_GET['orgId'] : ''; // Retrieve orgId from the URL
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - <?php echo $orgName; ?></title>
  <link rel="stylesheet" href="./styles/organization-authentication.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert included -->
</head>

<body>
  <header>
    <!-- link to go back to home to be added later -->
  </header>

  <main>
    <div class="signup-container">
      <h2><?php echo $orgName . $orgId; ?> User Sign Up</h2>
      <form id="signup-form" action="organization-signup-process.php?orgName=<?php echo urlencode($orgName); ?>" method="post">
        <!-- Include the organization name as a hidden input field -->
        <input type="hidden" name="orgName" value="<?php echo $orgName; ?>">
        <input type="hidden" name="orgId" value="<?php echo $orgId; ?>">
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br><br>
        <input type="submit" value="Sign Up">
      </form>

      <!-- Add login link -->
      <p>Already have an account? <a href="organization-login.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>">Log In</a></p>
    </div>
    <br>
    <hr>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> Feedback Hub360</p>
  </footer>

  <script>
    document.getElementById('signup-form').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent the form from submitting the traditional way

      var formData = new FormData(this);

      fetch(this.action, {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(result => {
          if (result.trim() === 'success') {
            Swal.fire({
              title: 'Success!',
              text: 'Your account has been created successfully.',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(() => {
              window.location.href = 'organization-login.php?orgName=<?php echo urlencode($orgName); ?>&orgId=<?php echo $orgId; ?>';
            });
          } else {
            Swal.fire({
              title: 'Error!',
              text: result,
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