<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About | DocApp</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      /* padding: 0; */
      background: #f4f6f9;
      color: #333;
    }

    header {
      margin-top: 8rem;
      /* background-color: #003366; */
      /* padding: 20px; */
      text-align: center;
      color: white;
    }

    h1{
        color: black;
    }

    section {
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      border-left: 5px solid #007bff;
      padding-left: 10px;
      margin-bottom: 20px;
      color: #003366;
    }

    .section {
      margin-bottom: 40px;
    }

    .card {
      background: #e9f0fa;
      padding: 20px;
      border-radius: 10px;
      margin-top: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .profile {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }

    .profile img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 15px;
      border: 2px solid #003366;
    }

    .profile h4 {
      margin: 0;
      font-size: 1.1em;
    }

    .profile p {
      margin: 0;
      color: #555;
      font-size: 0.9em;
    }
  </style>
</head>
<body>

  <header>
    <h1>About - DocApp</h1>
  </header>
<section>
  <div class="container">

    <div class="section">
      <h2>About This Website</h2>
      <p>DocApp is a smart medical appointment system designed to make the process of booking, managing, and tracking doctor appointments seamless and efficient. Our goal is to connect patients and doctors in a user-friendly digital environment. The system includes doctor profiles, scheduling, patient login, payments, and more.</p>
    </div>

    <div class="section">
      <h2>About Us</h2>

      <!-- Supervisor Card -->
      <div class="card">
        <div class="profile">
          <img src="imagesforweb/profile.jpg" alt="Supervisor Image">
          <div>
            <h4>Nishat Sadaf Lira</h4>
            <p>Lecturer, Department of Computer Science</p>
            <p>Daffodil Internation University</p>
            <p>Saver, Ashulia, Dhaka</p>
          </div>
        </div>
      </div>

      <!-- Team Members Card -->
      <div class="card">
        <h3 style="margin-bottom: 15px; color: #003366;">Our Team Members</h3>

        <div class="profile">
          <img src="imagesforweb/member1.jpg" alt="Member 1">
          <div>
            <h4>Dhrubo Mondol (Team leader)</h4>
            <p>Software Developer</p>
          </div>
        </div>

        <div class="profile">
          <img src="imagesforweb/male.jpg" alt="Member 2">
          <div>
            <h4>Rifat Khan</h4>
            <p>Frontend Developer</p>
          </div>
        </div>

        <div class="profile">
          <img src="imagesforweb/member3.jpg" alt="Member 3">
          <div>
            <h4>MD Osman Goni Khan</h4>
            <p>Backend Developer</p>
          </div>
        </div>

        <div class="profile">
          <img src="imagesforweb/male.jpg" alt="Member 4">
          <div>
            <h4>Mannan Hossain</h4>
            <p>Database Tester</p>
          </div>
        </div>

        <div class="profile">
          <img src="imagesforweb/male.jpg" alt="Member 4">
          <div>
            <h4>Sohanur Rahman</h4>
            <p>UI/UX Designer</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
</body>
</html>
