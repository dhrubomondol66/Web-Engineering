<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dermatology - Departments</title>
  <link rel="stylesheet" href="style/general.css" />
</head>

<body>
  <nav>
    <a href="department.php">
      <img src="imagesforweb/back.png" alt="Back" class="img1" />
      <img src="imagesforweb/DocApp_Medical_Logo_Design.png" alt="Logo" class="img2" />
    </a>
    <h1>Dermatology</h1>
    <div class="nav-right">
      <div class="user-menu">
        <button class="user-btn" onclick="toggleDropdown()">
          <img src="imagesforweb/user_icon.jpg" alt="User Icon" class="user-icon" />
          <span class="username">Username</span>
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
      <h2>Welcome to the Dermatology Department</h2>
      <p>
        The Cardiology Department specializes in diagnosing and treating heart and blood vessel-related conditions. Our expert cardiologists provide personalized care for both acute and chronic cardiovascular diseases, ensuring the best possible outcomes through advanced diagnostics, treatment, and rehabilitation.
      </p>

      <h3>Key Services:</h3>
      <ul>
        <li>Cardiac screening and risk assessment</li>
        <li>Electrocardiogram (ECG) and echocardiography</li>
        <li>Stress testing and Holter monitoring</li>
        <li>Management of hypertension and heart failure</li>
        <li>Coronary artery disease diagnosis and care</li>
        <li>Pre- and post-operative cardiac care</li>
        <li>Interventional cardiology (angioplasty, stenting)</li>
        <li>Pacemaker and device implantation</li>
      </ul>

      <h3>Our Doctors:</h3>
      <p>
        Our cardiologists are board-certified specialists with extensive experience in complex heart conditions. They work in close coordination with other departments like general medicine, emergency care, and surgery to ensure comprehensive cardiovascular care for all patients.
      </p>

      <h3>When to Visit:</h3>
      <ul>
        <li>Chest pain, shortness of breath, or palpitations</li>
        <li>High blood pressure or high cholesterol</li>
        <li>History of heart attack or stroke</li>
        <li>Family history of heart disease</li>
        <li>Swelling in legs, dizziness, or fainting</li>
        <li>Irregular heartbeats or fatigue</li>
      </ul>

      <h3>Book an Appointment:</h3>
      <p>
        Schedule your <a href="appointment.html">appointment</a> online or contact our front desk for assistance. We offer timely consultations, diagnostic testing, and tailored treatment plans both in-person and via telehealth.
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
