<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Organization</title>
  <link rel="stylesheet" href="./styles/add-organization.css" />
  <link rel="stylesheet" href="./styles/index.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <div class="title-text">Add Organization</div>
  <main class="main-section-add-organization"></main>
  <div class="organization-form">

    <form id="addOrganizationForm" method="post">
      <h3>Add New Organization</h3>
      <label for="orgName">Organization Name:</label><br />
      <input type="text" id="orgName" name="orgName" /><br /><br />

      <label for="orgType">Organization Type:</label><br />
      <select id="orgType" name="orgType">
        <option value="education">Education</option>
        <option value="business">Business</option>
      </select><br /><br />

      <label for="address">Address:</label><br />
      <input type="text" id="address" name="address" /><br /><br />
      <hr />

      <h3>Admin Details</h3>

      <label for="adminName">Admin's Name:</label><br />
      <input type="text" id="adminName" name="adminName" /><br /><br />

      <label for="adminEmail">Admin's Email:</label><br />
      <input type="email" id="adminEmail" name="adminEmail" /><br /><br />

      <label for="adminPassword">Admin's Password:</label><br />
      <input type="password" id="adminPassword" name="adminPassword" /><br /><br />

      <label for="confirmPassword">Confirm Password:</label><br />
      <input type="password" id="confirmPassword" name="confirmPassword" /><br /><br />

      <input type="submit" value="Submit" />
    </form>
  </div>
  <script src="sript.js"></script>
</body>

</html>