function loadHome() {
  fetch("home-org.php")
    .then((response) => response.text())
    .then((html) => {
      // Update the main section with the loaded home content
      document.querySelector(".main-section").innerHTML = html;

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
