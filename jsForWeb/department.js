
  function toggleDropdown() {
    const menu = document.getElementById("dropdown-menu");
    const isOpen = menu.style.display === "block";
    menu.style.display = isOpen ? "none" : "block";
  }

  // Optional: Close dropdown when clicking outside
  window.addEventListener("click", function (e) {
    const dropdown = document.getElementById("dropdown-menu");
    const button = document.querySelector(".user-btn");
    if (!dropdown.contains(e.target) && !button.contains(e.target)) {
      dropdown.style.display = "none";
    }
  });

