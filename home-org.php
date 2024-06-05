<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="./styles/home.css" />
  <link rel="stylesheet" href="./styles/index.css" />
</head>

<body>
  <div class="title-text">Home</div>
  <main class="main-section-home">
    <div class="top-cards">
      <div class="top-card">
        <div class="card">
          <div class="card-header">
            <img src="./icons/user.svg" alt="User Icon" class="user-icon" />
            <div class="user-count">
              <p class="card-number">3000</p>
            </div>
          </div>

          <div class="card-footer">
            <button class="footer-button" onclick="loadPendingOrganization()">
              Recent Feedbacks
            </button>
          </div>
        </div>
      </div>
      <div class="top-card">
        <div class="card">
          <div class="card-header">
            <img src="./icons/user.svg" alt="User Icon" class="user-icon" />
            <div class="user-count">
              <p class="card-number">3000</p>
            </div>
          </div>
          <div class="card-footer">
            <!-- <button class="footer-button" onclick="openOrganizationsPage()"> Organization Links</button>-->

            <button class="footer-button" onclick="loadOrganizationsPage()">
              Pending Actions
            </button>
          </div>
        </div>
      </div>

      <div class="top-card">
        <div class="card">
          <div class="card-header">
            <img src="./icons/user.svg" alt="User Icon" class="user-icon" />
            <div class="user-count">
              <p class="card-number">3000</p>
            </div>
          </div>
          <div class="card-footer">
            <button id="createTablesBtn" class="footer-button">
              Total Users
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="bottom-cards">
      <div class="bottom-card">
        <div class="card">
          <h2>Card 4</h2>
          <p>Top Feedback Categories
          </p>
        </div>
      </div>
      <div class="bottom-card">
        <div class="card">
          <h2>Card 5</h2>
          <p>Security status and alerts</p>
        </div>
      </div>
    </div>
  </main>

  <script src="sript-org.js"></script>
</body>

</html>