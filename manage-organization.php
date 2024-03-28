<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Organization</title>
  <link rel="stylesheet" href="./styles/manage-organization.css" />
  <link rel="stylesheet" href="./styles/index.css" />
</head>

<body>
  <div class="title-text">Manage Organization</div>
  <main class="main-section-manage-organization"></main>
  <div class="manage-organization-container">
    <div class="options">
      <input type="text" placeholder="Search Organizations" />
      <button><img src="./icons/search.svg" alt="Search" /></button>
      <select id="organizationFilter">
        <option value="all">All</option>
        <option value="education">Education</option>
        <option value="business">Business</option>
      </select>
    </div>
    <div class="organization-section">
      <div class="organization-list">
        <h3>Organization List</h3>
        <table>
          <thead>
            <tr>
              <th>Organization Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="organizationTableBody">

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const organizationFilter = document.getElementById("organizationFilter");
      const organizationTableBody = document.getElementById("organizationTableBody");

      // Function to load organization data if "All" is selected
      function loadOrganizationData() {
        const filterValue = organizationFilter.value;

        // Clear the table body first
        organizationTableBody.innerHTML = '';

        // If filter is set to "All", load organization data
        if (filterValue === 'all') {
          fetch('get-organization.php')
            .then(response => response.text())
            .then(data => {
              organizationTableBody.innerHTML = data;
            })
            .catch(error => console.error('Error loading organization data:', error));
        }
      }

      // Load organization data initially when the page loads
      loadOrganizationData();

      // Listen for changes in the select element
      organizationFilter.addEventListener("change", loadOrganizationData);
    });
  </script>
</body>

</html>