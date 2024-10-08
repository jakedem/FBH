<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="./styles/home.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="./styles/index.css" />
</head>

<body>
  <div class="title-text">Home</div>
  <main class="main-section-home">
    <div class="top-cards">
      <div class="top-card">
        <div class="card">
          <div class="card-header">
            <img src="./icons/approve.svg" alt="User Icon" class="user-icon" />
            <div class="user-count">
              <p id="pending-count" class="card-number"></p>
            </div>
          </div>

          <div class="card-footer">
            <button class="footer-button" onclick="loadPendingOrganization()">
              Pending Organizations
            </button>
          </div>
        </div>
      </div>
      <div class="top-card">
        <div class="card">
          <div class="card-header">
            <img src="./icons/linklist.svg" alt="User Icon" class="user-icon" />
            <div class="user-count">
              <p id="org-count" class="card-number"></p>
            </div>
          </div>
          <div class="card-footer">
            <!-- <button class="footer-button" onclick="openOrganizationsPage()"> Organization Links</button>-->

            <button class="footer-button" onclick="loadOrganizationsPage()">
              Organization Links
            </button>
          </div>
        </div>
      </div>

      <div class="top-card">
        <div class="card">
          <div class="card-header">
            <img src="./icons/admin.svg" alt="User Icon" class="user-icon" />
            <!-- <div class="user-count">
              <p class="card-number">400</p>
            </div> -->
          </div>
          <div class="card-footer">
            <button id="createTablesBtn" class="footer-button">
              Initialize Organization
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="bottom-cards">
      <div class="bottom-card">
        <div class="card">
          <h2>Card 4</h2>
          <p>
            This is the content of Card 4 There is more to come so hold on .
          </p>
        </div>
      </div>
      <div class="bottom-card">
        <div class="card">
          <h2>Card 5</h2>
          <p>
            This is the content of Card 5 There is more to come so hold on .
          </p>
        </div>
      </div>
    </div> -->
  </main>

  <script src="sript.js"></script>
</body>

</html>