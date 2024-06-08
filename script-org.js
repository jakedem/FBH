function loadHome() {
  fetch("home-org.php")
    .then((response) => response.text())
    .then((html) => {
      // Update the main section with the loaded home content
      document.querySelector(".main-section").innerHTML = html;

      // Load and render the bar chart
      loadFeedbackChart();

      // After loading the home content, fetch the feedback count
      fetch("feedback-count.php")
        .then((response) => response.json())
        .then((data) => {
          // Check if the response contains the feedback count
          if (data.feedbackCount !== undefined) {
            // Update the content of the element with the feedback count
            const feedbackCountElement =
              document.getElementById("feedback-count");
            if (feedbackCountElement) {
              feedbackCountElement.textContent = data.feedbackCount;
            }
          } else {
            console.error("Feedback count not found in response");
          }
        })
        .catch((error) =>
          console.error("Error loading feedback count:", error)
        );

      // After loading the home content, fetch the anonymous feedback count
      fetch("anonymous-feedback-count.php")
        .then((response) => response.json())
        .then((data) => {
          // Check if the response contains the anonymous feedback count
          if (data.anonymousFeedbackCount !== undefined) {
            // Update the content of the element with the anonymous feedback count
            const anonymousFeedbackCountElement = document.getElementById(
              "anonymous-feedback-count"
            );
            if (anonymousFeedbackCountElement) {
              anonymousFeedbackCountElement.textContent =
                data.anonymousFeedbackCount;
            }
          } else {
            console.error("Anonymous feedback count not found in response");
          }
        })
        .catch((error) =>
          console.error("Error loading anonymous feedback count:", error)
        );

      // After loading the home content, fetch the user count
      fetch("user-count.php")
        .then((response) => response.json())
        .then((data) => {
          // Check if the response contains the user count
          if (data.userCount !== undefined) {
            // Update the content of the element with the user count
            const userCountElement = document.getElementById("user-count");
            if (userCountElement) {
              userCountElement.textContent = data.userCount;
            }
          } else {
            console.error("User count not found in response");
          }
        })
        .catch((error) => console.error("Error loading user count:", error));

      // Add event listener to "Total Feedback" button
      const totalFeedbackButton = document.querySelector(".footer-button");
      totalFeedbackButton.addEventListener("click", loadFeedback);

      // Add event listener to "Anonymous Feedback" button
      const totalAnonymousFeedbackButton =
        document.querySelector(".footer-button");
      totalAnonymousFeedbackButton.addEventListener("click", loadFeedback);

      // Add event listener to "Total Feedback" button
      const totalUserskButton = document.querySelector(".footer-button");
      totalUserskButton.addEventListener("click", loadFeedback);
    })

    .catch((error) => console.error("Error loading home:", error));
}

function loadFeedback() {
  fetch("get-feedback.php")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;
    })
    .catch((error) => console.error("Error loading feedback:", error));
}

function loadAnonymousFeedback() {
  fetch("get-anonymous-feedback.php")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;
    })
    .catch((error) => console.error("Error loading feedback:", error));
}

function loadUsers() {
  fetch("get-users.php")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;
    })
    .catch((error) => console.error("Error loading users:", error));
}

// Function to load feedback chart data and render the bar chart
function loadFeedbackChart() {
  fetch("feedback-barchart.php")
    .then((response) => response.json())
    .then((data) => {
      console.log("Data received:", data); // Debugging statement
      if (data.error) {
        console.error("Error:", data.error);
        return;
      }

      const ctx = document.getElementById("feedbackChart").getContext("2d");

      // Define colors for each category
      const colors = [
        "rgba(255, 99, 132, 0.2)", // Color for first category
        "rgba(54, 162, 235, 0.2)", // Color for second category
        "rgba(75, 192, 192, 0.2)", // Color for third category
        "rgba(153, 102, 255, 0.2)", // Color for fourth category
        "rgba(255, 206, 86, 0.2)", // Additional colors if needed
        "rgba(255, 159, 64, 0.2)",
      ];

      const borderColors = [
        "rgba(255, 99, 132, 1)",
        "rgba(54, 162, 235, 1)",
        "rgba(75, 192, 192, 1)",
        "rgba(153, 102, 255, 1)",
        "rgba(255, 206, 86, 1)",
        "rgba(255, 159, 64, 1)",
      ];

      // Generate background and border colors for the dataset
      const backgroundColors = data.feedbackTypes.map(
        (_, index) => colors[index % colors.length]
      );
      const borderColorsArray = data.feedbackTypes.map(
        (_, index) => borderColors[index % borderColors.length]
      );

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: data.feedbackTypes,
          datasets: [
            {
              label: "Number of Feedback",
              data: data.feedbackCounts.map(Number), // Convert counts to numbers
              backgroundColor: backgroundColors,
              borderColor: borderColorsArray,
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });
    })
    .catch((error) =>
      console.error("Error loading feedback chart data:", error)
    );
}

function loadManageOrganization() {
  fetch("manage-organization.php")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;
      // Once the HTML content is loaded, execute the organization management logic
      initializeApprovedOrganizationManagement();
    })
    .catch((error) =>
      console.error("Error loading manage-organization:", error)
    );
}

document.addEventListener("DOMContentLoaded", function () {
  const menuIcon = document.querySelector(".menu-icon");
  const sidebar = document.querySelector(".sidebar");

  // Function to toggle sidebar visibility
  function toggleSidebar() {
    sidebar.classList.toggle("sidebar-visible");
  }

  // Event listener for menu icon click
  menuIcon.addEventListener("click", toggleSidebar);

  // Load home page automatically when the page loads
  loadHome();

  document.addEventListener("click", function (event) {
    // Check if the click target is not within the sidebar
    if (!sidebar.contains(event.target) && !menuIcon.contains(event.target)) {
      // Close the sidebar if it's currently open
      if (sidebar.classList.contains("sidebar-visible")) {
        toggleSidebar();
      }
    }
  });

  // Function to handle link clicks in the sidebar
  function handleSidebarLinkClick() {
    // Close the sidebar
    if (sidebar.classList.contains("sidebar-visible")) {
      toggleSidebar();
    }
  }

  // Attach click event listeners to sidebar links
  const sidebarLinks = document.querySelectorAll(".side-links a");
  sidebarLinks.forEach(function (link) {
    link.addEventListener("click", handleSidebarLinkClick);
  });
});
