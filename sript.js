function loadHome() {
  fetch("home.html")
    .then((response) => response.text())
    .then((html) => {
      document.querySelector(".main-section").innerHTML = html;
    })
    .catch((error) => console.error("Error loading home:", error));
}
