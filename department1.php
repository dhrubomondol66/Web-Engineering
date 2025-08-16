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
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Departments</title>
  <link rel="stylesheet" href="style/departments.css"> <!-- Linking external CSS -->

  <style>
    /* nav {
      background-color: #0077cc;
      padding: 15px;
      color: white;
      text-align: center;
    } */

    .search-container {
      text-align: center;
      margin: 20px auto;
    }

    #searchInput {
      width: 60%;
      padding: 10px;
      font-size: 16px;
      border-radius: 8px;
      border: 1px solid #ccc;
      outline: none;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .services-section h2 {
      margin-top: 30px;
      font-size: 1.5rem;
      text-align: center;
      color: #333;
    }

    /* .department-list {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 12px;
      margin: 20px auto;
      max-width: 900px;
    }

    .department-list a {
      padding: 12px 20px;
      background-color: #f0f0f0;
      border-radius: 6px;
      text-decoration: none;
      color: #0077cc;
      border: 1px solid #0077cc;
      transition: background 0.3s, color 0.3s;
    }

    .department-list a:hover {
      background-color: #0077cc;
      color: white;
    }

    hr {
      margin: 20px auto;
      width: 90%;
    } */
  </style>
</head>
<body>  
  <nav>
    <h1>Departments</h1>
  </nav>

  <section>
    <hr><br>

    <!-- 🔍 Search bar -->
    <div class="search-container">
      <input type="text" id="searchInput" onkeyup="filterDepartments()" placeholder="Search for departments...">
    </div>

    <!-- Recommended Departments -->
    <div>
      <h2>Recommended Doctor Departments</h2>
      <div class="department-list">
        <a href="general.php">General Medicine</a>
        <a href="cardiology.php">Cardiology</a>
        <a href="dermatology">Dermatology</a>
        <a href="pediatrics">Pediatrics (Children)</a>
        <a href="orthopedics">Orthopedics (Bones & Joints)</a>
        <a href="gynecology">Gynecology (Women's Health)</a>
        <a href="neurology">Neurology (Brain & Nerves)</a>
        <a href="ent">ENT (Ear, Nose, Throat)</a>
        <a href="ophthalmology">Ophthalmology (Eye)</a>
        <a href="psychiatry">Psychiatry (Mental Health)</a>
        <a href="urology">Urology (Urinary System)</a>
        <a href="gastroenterology">Gastroenterology (Stomach & Digestive)</a>
        <a href="oncology">Oncology (Cancer)</a>
        <a href="dentistry">Dentistry (Teeth & Oral Health)</a>
        <a href="pulmonology">Pulmonology (Lungs & Breathing)</a>
      </div>
    </div>

    <!-- Optional Departments -->
    <div>
      <h2>Optional Additional Departments</h2>
      <div class="department-list">
        <a href="nephrology">Nephrology</a>
        <a href="endocrinology">Endocrinology (Hormones, Diabetes)</a>
        <a href="rheumatology">Rheumatology (Arthritis)</a>
        <a href="infectiousDiseases">Infectious Diseases</a>
        <a href="nutrition&dietetics">Nutrition & Dietetics</a>
        <a href="anesthesiology">Anesthesiology</a>
        <a href="surgery">Surgery (General or specialized)</a>
      </div>
    </div>

    <hr>
  </section>

  <!-- ✅ JavaScript for Live Search -->
  <script>
    function filterDepartments() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const departmentLists = document.querySelectorAll('.department-list');

      departmentLists.forEach(list => {
        const links = list.querySelectorAll('a');
        links.forEach(link => {
          const text = link.textContent.toLowerCase();
          link.style.display = text.includes(input) ? 'inline-block' : 'none';
        });
      });
    }
  </script>
</body>
</html>
