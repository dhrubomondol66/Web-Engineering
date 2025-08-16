<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Users_profile.php"); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['username'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>General Medicine - Departments</title>
  <link rel="stylesheet" href="style/general.css" />
</head>

<body>
  <nav>
    <a href="userDashboard.php">
      <!-- <img src="imagesforweb/back.png" alt="Back" class="img1" /> -->
      <img src="imagesforweb/DocApp_Medical_Logo_Design.png" alt="Logo" class="img2" />
    </a>
    <h1>General Medicine</h1>
    <div class="nav-right">
      <div class="user-menu">
        <button class="user-btn" onclick="toggleDropdown()">
          <img src="imagesforweb/user_icon.jpg" alt="User Icon" class="user-icon" />
          <span class="username"><?php echo htmlspecialchars($username); ?></span>
          <span class="arrow" id="arrow">&#9662;</span>
        </button>
        <div class="dropdown" id="dropdown-menu">
          <a href="Users_profile.php">My Profile</a>
          <a href="edit_user_profile.php">Edit Profile</a>
          <a href="#">Report a bug</a>
          <a href="certificates.php">My Certificates</a>
          <a href="bookmarks.php">My Bookmarks</a>
          <hr />
          <button class="logout-btn" onclick="window.location.href='guest.php'">LOGOUT</button>
        </div>
      </div>
    </div>
  </nav>

  <section class="department-section">
    <div class="container">
      <h2>Welcome to the General Medicine Department</h2>
      <p>
        General Medicine, also known as Internal Medicine, deals with the prevention, diagnosis, and treatment of adult diseases. Our department serves as the first point of contact for patients and is equipped to manage a wide variety of illnesses ranging from common colds to chronic diseases like diabetes, hypertension, and asthma.
      </p>
      <h3>Key Services:</h3>
      <ul>
        <li>Diagnosis and management of chronic diseases</li>
        <li>Routine health checkups and screenings</li>
        <li>Infection control and treatment (e.g., fever, flu, respiratory issues)</li>
        <li>Lifestyle counseling and preventive care</li>
        <li>Coordination with specialists when needed</li>
        <li>Emergency care for internal medicine issues</li>
        <li>Comprehensive treatment planning with multidisciplinary support</li>
        <li>Vaccination and immunization programs</li>
      </ul>

      <h3>Our Doctors:</h3>
      <p>
        Our general medicine doctors are highly trained physicians with vast experience in clinical care. They collaborate with other departments for integrated and personalized treatment plans. Each physician undergoes continuous training and education to stay up-to-date with the latest in medical science.
      </p>

      <h3>When to Visit:</h3>
      <ul>
        <li>Unexplained symptoms like fatigue or pain</li>
        <li>Frequent infections or recurring illnesses</li>
        <li>Regular health maintenance and screenings</li>
        <li>Chronic condition monitoring</li>
        <li>Follow-up care after hospital discharge</li>
        <li>Health advice and second opinions</li>
      </ul>

      <h3>Book an Appointment:</h3>
      <p>
        You can <a class="button-a" href="bookDoctor.php">book an appointment</a> online or contact our reception desk for more information. Appointments are available for in-person visits as well as teleconsultations, ensuring flexibility and convenience for all patients.
      </p>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 DocApp - All Rights Reserved.</p>
  </footer>

  <script>
    function toggleDropdown() {
      const menu = document.getElementById("dropdown-menu");
      menu.classList.toggle("show");
    }
  </script>
</body>

</html>
