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
  <main class="main-section-manage-organization">
    <div class="manage-organization-container">
      <div class="options">
        <input type="text" placeholder="Search Organizations" />
        <button id="searchButton"><img src="./icons/search.svg" alt="Search" /></button>
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
  </main>

  <script src="script.js"></script>

</body>

</html>