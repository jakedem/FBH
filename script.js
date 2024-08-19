function loadHome() {
  fetch("home.php")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;

      // After loading the home content, fetch the pending count
      fetch("pending-count.php")
        .then((response) => response.json())
        .then((data) => {
          // Check if the response contains the feedback count
          if (data.pendingCount !== undefined) {
            // Update the content of the element with the feedback count
            const pendingCountElement =
              document.getElementById("pending-count");
            if (pendingCountElement) {
              pendingCountElement.textContent = data.pendingCount;
            }
          } else {
            console.error("Pending Approval count not found in response");
          }
        })
        .catch((error) => console.error("Error loading pending count:", error));

      // After loading the home content, fetch the org count
      fetch("org-count.php")
        .then((response) => response.json())
        .then((data) => {
          // Check if the response contains the feedback count
          if (data.orgCount !== undefined) {
            // Update the content of the element with the feedback count
            const orgCountElement = document.getElementById("org-count");
            if (orgCountElement) {
              orgCountElement.textContent = data.orgCount;
            }
          } else {
            console.error("Organization Link count not found in response");
          }
        })
        .catch((error) =>
          console.error("Error loading organization links count:", error)
        );

      // Add event listener for creating organization tables
      document
        .getElementById("createTablesBtn")
        .addEventListener("click", function () {
          // Send AJAX request to create tables
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "create-organization-tables.php", true);
          xhr.setRequestHeader(
            "Content-Type",
            "application/x-www-form-urlencoded"
          );
          xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
              if (xhr.status === 200) {
                // Display response from PHP script using SweetAlert
                Swal.fire({
                  title: "Success",
                  text: xhr.responseText,
                  icon: "success",
                  confirmButtonText: "OK",
                });
              } else {
                // Display error message using SweetAlert
                Swal.fire({
                  title: "Error",
                  text: xhr.statusText,
                  icon: "error",
                  confirmButtonText: "OK",
                });
              }
            }
          };
          xhr.send();
        });
    })
    .catch((error) => {
      Swal.fire({
        title: "Error",
        text: "Error loading home: " + error,
        icon: "error",
        confirmButtonText: "OK",
      });
      console.error("Error loading home:", error);
    });
}

function loadPendingOrganization() {
  fetch("pending-organization.php")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;
      // If you have any initialization logic specific to the pending organization page, you can call it here
      initializeOrganizationManagement();
    })
    .catch((error) =>
      console.error("Error loading pending-organization:", error)
    );
}

function loadAddOrganization() {
  fetch("add-organization.php") // Ensure you fetch the correct HTML file
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;

      // Add event listener to the dynamically loaded form
      document
        .getElementById("addOrganizationForm")
        .addEventListener("submit", function (event) {
          event.preventDefault(); // Prevent the default form submission

          const formData = new FormData(this);

          fetch("submit-form-organization.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => response.text())
            .then((result) => {
              if (
                result.includes("New organization and admin added successfully")
              ) {
                Swal.fire(
                  "Success",
                  "New organization added successfully!",
                  "success"
                );
              } else if (result.includes("Invalid email address.")) {
                Swal.fire("Error", "Invalid email address.", "error");
              } else {
                Swal.fire("Error", "Failed to add organization.", "error");
              }
            })
            .catch((error) => {
              Swal.fire(
                "Error",
                "There was an error processing your request.",
                "error"
              );
            });
        });
    })
    .catch((error) => console.error("Error loading add-organization:", error));
}

function loadSendEmail() {
  fetch("send-mail.html")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;

      // Now add the event listener to the dynamically loaded form
      document
        .getElementById("sendEmailForm")
        .addEventListener("submit", function (event) {
          event.preventDefault(); // Prevent the default form submission

          const formData = new FormData(this);

          fetch("send-mail.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => response.text())
            .then((result) => {
              if (result.includes("Email sent successfully!")) {
                Swal.fire("Success", "Email sent successfully!", "success");
              } else if (result.includes("Invalid email address.")) {
                Swal.fire("Error", "Invalid email address.", "error");
              } else {
                Swal.fire("Error", "Failed to send email.", "error");
              }
            })
            .catch((error) => {
              Swal.fire(
                "Error",
                "There was an error processing your request.",
                "error"
              );
            });
        });
    })
    .catch((error) => console.error("Error loading send email page:", error));
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

function loadSystemSecurity() {
  fetch("scan.html")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;

      // Initialize scan button functionality
      document
        .getElementById("scanButton")
        .addEventListener("click", function () {
          fetch("scan.php")
            .then((response) => response.json())
            .then((data) => {
              // Display Performance Scan Results
              const performanceResultsDiv =
                document.getElementById("performanceResults");
              performanceResultsDiv.innerHTML = `
              <p><strong>Slow Queries:</strong> ${
                Array.isArray(data.slowQueries) ? data.slowQueries.length : "0"
              } found</p>
            `;

              // Display additional details with expand/collapse functionality
              const additionalDiv =
                document.getElementById("additionalDetails");
              additionalDiv.innerHTML = `
              <h4>Table Sizes</h4>
              <ul>${data.tableSizes
                .map(
                  (item) => `<li>${item.Table}: ${item["Size (MB)"]} MB</li>`
                )
                .join("")}</ul>
              <h4>Index Usage</h4>
              <ul>${data.indexUsage
                .map(
                  (item) =>
                    `<li>Table: ${item.table_name}, Index: ${item.index_name}, Column: ${item.column_name}</li>`
                )
                .join("")}</ul>
            `;

              document.getElementById("expandButton").style.display = "block";
              additionalDiv.style.display = "none"; // Initially hide

              // Display Security Scan Results
              const securityScanDiv = document.getElementById("securityScan");
              securityScanDiv.innerHTML = `
              <p>${
                Array.isArray(data.passwordVulnerabilities)
                  ? `Password vulnerabilities found: ${data.passwordVulnerabilities.length}`
                  : "No password vulnerabilities found"
              }</p>
            `;
            });
        });

      // Initialize expand/collapse functionality
      document
        .getElementById("expandButton")
        .addEventListener("click", function () {
          const additionalDiv = document.getElementById("additionalDetails");
          additionalDiv.style.display =
            additionalDiv.style.display === "none" ? "block" : "none";
        });
    })
    .catch((error) => console.error("Error loading security:", error));
}

// Call the function to load the content
loadSystemSecurity();

function loadOrganizationsPage() {
  fetch("organizations.php")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;
    })
    .catch((error) =>
      console.error("Error loading organizations page:", error)
    );
}

function loadSystemSettings() {
  fetch("settings.html")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;
    })
    .catch((error) => console.error("Error loading settings page:", error));
}

function openOrganizationsPage() {
  // Open the organizations.php page in a new tab
  window.open("organizations.php", "_blank");
}

function initializeOrganizationManagement() {
  const organizationFilter = document.getElementById("organizationFilter");
  const organizationTableBody = document.getElementById(
    "organizationTableBody"
  );

  // Function to load organization data based on selected filter
  function loadOrganizationData() {
    const filterValue = organizationFilter.value;

    // Clear the table body first
    organizationTableBody.innerHTML = "";

    // Load different PHP files based on the selected filter
    let phpFile = "";

    switch (filterValue) {
      case "education":
        phpFile = "get-education.php";
        break;
      case "business":
        phpFile = "get-business.php";
        break;
      default:
        phpFile = "get-organization.php";
        break;
    }

    // Fetch data from the selected PHP file
    fetch(phpFile)
      .then((response) => response.text())
      .then((data) => {
        organizationTableBody.innerHTML = data;
        // Call function to attach event listeners to View buttons
        attachViewButtonListeners();
        // Call function to attach event listeners to Terminate buttons
        attachTerminateButtonListeners();
        // Attach event listener to "Approve" buttons
        attachApproveButtonListeners();
      })
      .catch((error) =>
        console.error("Error loading organization data:", error)
      );
  }

  // Function to display organization details in a modal
  function displayOrganizationModal(orgId) {
    // Fetch organization details from the server
    fetch(`get-organization-details.php?orgId=${orgId}`)
      .then((response) => response.json())
      .then((data) => {
        // Populate the modal with organization details
        document.getElementById("modalOrgId").textContent = data.orgId;
        document.getElementById("modalOrgName").textContent = data.orgName;
        document.getElementById("modalOrgType").textContent = data.orgType;
        document.getElementById("modalAddress").textContent = data.address;

        // Populate the modal with admin details
        document.getElementById("modalAdminId").textContent = data.adminId;
        document.getElementById("modalAdminName").textContent = data.adminName;
        document.getElementById("modalAdminEmail").textContent =
          data.adminEmail;

        // Show the modal
        document.getElementById("organizationModal").style.display = "block";

        // Attach event listener to the close button
        document.getElementById("closeModal").onclick = function () {
          closeModal();
        };
      })
      .catch((error) =>
        console.error("Error fetching organization details:", error)
      );
  }

  // Function to close the modal
  function closeModal() {
    document.getElementById("organizationModal").style.display = "none";
  }

  // Function to attach event listeners to View buttons
  function attachViewButtonListeners() {
    const viewButtons = document.querySelectorAll(".view");

    viewButtons.forEach((button) => {
      button.addEventListener("click", function () {
        // Get the organization ID from the data-org-id attribute
        const orgId = button.getAttribute("data-org-id");
        // Display organization details in modal
        displayOrganizationModal(orgId);
      });
    });
  }

  // Function to attach event listeners to Terminate buttons
  function attachTerminateButtonListeners() {
    const terminateButtons = document.querySelectorAll(".terminate");

    terminateButtons.forEach((button) => {
      button.addEventListener("click", function () {
        // Get the organization ID from the data-org-id attribute
        const orgId = button.getAttribute("data-org-id");

        // Send AJAX request to terminate-organization.php
        fetch("terminate-organization.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({ orgId: orgId }),
        })
          .then((response) => response.text())
          .then((responseText) => {
            // Use SweetAlert to show success or error message
            if (responseText.includes("Error")) {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: responseText,
              });
            } else {
              Swal.fire({
                icon: "success",
                title: "Success",
                text: responseText,
              });
            }
          })
          .catch((error) => {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "An error occurred while processing your request.",
            });
            console.error("Error:", error);
          });
      });
    });
  }

  // Function to handle organization search
  function searchOrganizations() {
    const searchInput = document.querySelector('.options input[type="text"]');
    const searchQuery = searchInput.value.trim();

    if (searchQuery !== "") {
      // Fetch data from the PHP script for search
      fetch(`search-organizations.php?searchQuery=${searchQuery}`)
        .then((response) => response.text())
        .then((data) => {
          organizationTableBody.innerHTML = data;
          // After loading search results, reattach event listeners to View buttons
          attachViewButtonListeners();
          // After loading search results, reattach event listeners to "Approve" buttons
          attachApproveButtonListeners();
          // After loading search results, reattach event listeners to Terminate buttons
          attachTerminateButtonListeners();
        })
        .catch((error) =>
          console.error("Error searching organizations:", error)
        );
    } else {
      // If search query is empty, load data based on filter
      loadOrganizationData();
    }
  }

  // Function to display approval success alert
  function displayApprovalSuccessAlert() {
    // Show SweetAlert indicating approval success
    Swal.fire({
      title: "Success!",
      text: "Organization approved successfully!",
      icon: "success",
      confirmButtonText: "OK",
    });
  }

  // Function to attach event listeners to "Approve" buttons
  function attachApproveButtonListeners() {
    const approveButtons = document.querySelectorAll(".approve");

    approveButtons.forEach((button) => {
      button.addEventListener("click", function () {
        // Get the organization ID from the data-org-id attribute
        const orgId = button.getAttribute("data-org-id");
        // Send AJAX request to approve organization
        approveOrganization(orgId);
      });
    });
  }

  // Function to approve organization via AJAX
  function approveOrganization(orgId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "approve-organization.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Request was successful
          console.log(xhr.responseText);
          // Display approval success alert
          displayApprovalSuccessAlert();
          // Reload organization data after approval
          loadOrganizationData();
        } else {
          // Request failed
          console.error("Error:", xhr.statusText);
        }
      }
    };
    xhr.send("orgId=" + encodeURIComponent(orgId));
  }

  // Load organization data initially when the page loads
  loadOrganizationData();

  // Listen for changes in the select element
  organizationFilter.addEventListener("change", loadOrganizationData);

  // Listen for input events on the search field
  const searchInput = document.querySelector('.options input[type="text"]');
  searchInput.addEventListener("input", searchOrganizations);
}

function initializeApprovedOrganizationManagement() {
  const organizationFilter = document.getElementById("organizationFilter");
  const organizationTableBody = document.getElementById(
    "organizationTableBody"
  );

  // Function to load organization data based on selected filter
  function loadOrganizationData() {
    const filterValue = organizationFilter.value;

    // Clear the table body first
    organizationTableBody.innerHTML = "";

    // Load different PHP files based on the selected filter
    let phpFile = "";

    switch (filterValue) {
      case "education":
        phpFile = "get-approved-education.php";
        break;
      case "business":
        phpFile = "get-approved-business.php";
        break;
      default:
        phpFile = "get-approved-organization.php";
        break;
    }

    // Fetch data from the selected PHP file
    fetch(phpFile)
      .then((response) => response.text())
      .then((data) => {
        organizationTableBody.innerHTML = data;
        // Call function to attach event listeners to View buttons
        attachViewButtonListeners();
        //Attach event listener to Terminate buttons
        attachTerminateButtonListeners();
      })
      .catch((error) =>
        console.error("Error loading organization data:", error)
      );
  }

  // Function to display organization details in a modal
  function displayOrganizationModal(orgId) {
    // Fetch organization details from the server
    fetch(`get-organization-details.php?orgId=${orgId}`)
      .then((response) => response.json())
      .then((data) => {
        // Populate the modal with organization details
        document.getElementById("modalOrgId").textContent = data.orgId;
        document.getElementById("modalOrgName").textContent = data.orgName;
        document.getElementById("modalOrgType").textContent = data.orgType;
        document.getElementById("modalAddress").textContent = data.address;

        // Populate the modal with admin details
        document.getElementById("modalAdminId").textContent = data.adminId;
        document.getElementById("modalAdminName").textContent = data.adminName;
        document.getElementById("modalAdminEmail").textContent =
          data.adminEmail;

        // Show the modal
        document.getElementById("organizationModal").style.display = "block";

        // Attach event listener to the close button
        document.getElementById("closeModal").onclick = function () {
          closeModal();
        };
      })
      .catch((error) =>
        console.error("Error fetching organization details:", error)
      );
  }

  // Function to close the modal
  function closeModal() {
    document.getElementById("organizationModal").style.display = "none";
  }

  // Function to attach event listeners to View buttons
  function attachViewButtonListeners() {
    const viewButtons = document.querySelectorAll(".view");

    viewButtons.forEach((button) => {
      button.addEventListener("click", function () {
        // Get the organization ID from the data-org-id attribute
        const orgId = button.getAttribute("data-org-id");
        // Display organization details in modal
        displayOrganizationModal(orgId);
      });
    });
  }

  // Function to attach event listeners to Terminate buttons
  function attachTerminateButtonListeners() {
    const terminateButtons = document.querySelectorAll(".terminate");

    terminateButtons.forEach((button) => {
      button.addEventListener("click", function () {
        // Get the organization ID from the data-org-id attribute
        const orgId = button.getAttribute("data-org-id");

        // Send AJAX request to terminate-organization.php
        fetch("terminate-organization.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({ orgId: orgId }),
        })
          .then((response) => response.text())
          .then((responseText) => {
            // Use SweetAlert to show success or error message
            if (responseText.includes("Error")) {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: responseText,
              });
            } else {
              Swal.fire({
                icon: "success",
                title: "Success",
                text: responseText,
              });
            }
          })
          .catch((error) => {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "An error occurred while processing your request.",
            });
            console.error("Error:", error);
          });
      });
    });
  }

  // Function to handle organization search
  function searchOrganizations() {
    const searchInput = document.querySelector('.options input[type="text"]');
    const searchQuery = searchInput.value.trim();

    if (searchQuery !== "") {
      // Fetch data from the PHP script for search
      fetch(`search-approved-organizations.php?searchQuery=${searchQuery}`)
        .then((response) => response.text())
        .then((data) => {
          organizationTableBody.innerHTML = data;
          // After loading search results, reattach event listeners to View buttons
          attachViewButtonListeners();
          // After loading search results, reattach event listerners to terminate buttons
          attachTerminateButtonListeners();
        })
        .catch((error) =>
          console.error("Error searching organizations:", error)
        );
    } else {
      // If search query is empty, load data based on filter
      loadOrganizationData();
    }
  }

  // Load organization data initially when the page loads
  loadOrganizationData();

  // Listen for changes in the select element
  organizationFilter.addEventListener("change", loadOrganizationData);

  // Listen for input events on the search field
  const searchInput = document.querySelector('.options input[type="text"]');
  searchInput.addEventListener("input", searchOrganizations);
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
