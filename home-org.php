<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="./styles/home.css" />
  <link rel="stylesheet" href="./styles/index.css" />
  <!-- <link rel="stylesheet" href="./styles/barchart.css"> -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="title-text">Home</div>
  <main class="main-section-home">
    <div class="top-cards">
      <div class="top-card">
        <div class="card">
          <div class="card-header">
            <img src="./icons/feedback3.svg" alt="User Icon" class="user-icon" />
            <div class="user-count">
              <p id="feedback-count" class="card-number"></p>
            </div>
          </div>
          <div class="card-footer">
            <button class="footer-button" onclick="loadFeedback()">
              Total Feedback
            </button>
          </div>
        </div>
      </div>
      <div class="top-card">
        <div class="card">
          <div class="card-header">
            <img src="./icons/anonymous.svg" alt="User Icon" class="user-icon" />
            <div class="user-count">
              <p id="anonymous-feedback-count" class="card-number"></p>
            </div>
          </div>
          <div class="card-footer">
            <button class="footer-button" onclick="loadAnonymousFeedback()">
              Anonymous Feedback
            </button>
          </div>
        </div>
      </div>

      <div class="top-card">
        <div class="card">
          <div class="card-header">
            <img src="./icons/user.svg" alt="User Icon" class="user-icon" />
            <div class="user-count">
              <p id="user-count" class="card-number"></p>
            </div>
          </div>
          <div class="card-footer">
            <button id="createTablesBtn" class="footer-button" onclick="loadUsers()">
              Total Users
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- New section for the bar chart -->
    <div class="chart-container">
      <canvas id="feedbackChart"></canvas>
    </div>
  </main>

  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
  <script src="sript-org.js"></script>

  <script>
    // Placeholder for the script to fetch data and render the chart
  </script>
</body>

</html>