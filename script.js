// External script file (script.js)

function loadHome() {
  fetch("home.html")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;
    })
    .catch((error) => console.error("Error loading home:", error));
}

function loadAddOrganization() {
  fetch("add-organization.html")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;
    })
    .catch((error) => console.error("Error loading add-organization:", error));
}

function loadManageOrganization() {
  fetch("manage-organization.php")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;
      // Once the HTML content is loaded, execute the organization management logic
      initializeOrganizationManagement();
    })
    .catch((error) =>
      console.error("Error loading manage-organization:", error)
    );
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
      })
      .catch((error) =>
        console.error("Error loading organization data:", error)
      );
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
