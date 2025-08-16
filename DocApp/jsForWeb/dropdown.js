function toggleDropdown() {
        const dropdown = document.getElementById("dropdown-menu");
        const arrow = document.getElementById("arrow");

        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        arrow.classList.toggle("up");
      }

      // Close dropdown when clicking outside
      document.addEventListener("click", function (e) {
        const menu = document.querySelector(".user-menu");
        const dropdown = document.getElementById("dropdown-menu");
        const arrow = document.getElementById("arrow");

        if (!menu.contains(e.target)) {
          dropdown.style.display = "none";
          arrow.classList.remove("up");
        }
      });