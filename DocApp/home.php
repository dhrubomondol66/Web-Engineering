<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DocApp - Onboarding</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body, html {
      height: 100%;
      width: 100%;
      overflow: hidden;
    }

    .container {
      display: flex;
      flex-direction: column;
      height: 100vh;
      width: 100vw;
    }

    .page {
      display: flex;
      height: 100vh;
      flex-direction: row;
      background-image: url('imagesforweb/title.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .left-section {
      flex: 1;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      color: white;
      position: relative;
      background: rgba(51, 52, 53, 0.16); /* Semi-transparent overlay for readability */
    }

    .left-section h1 {
      font-size: 3rem;
      font-weight: bold;
      color: black; /* Changed to white for better contrast on background */
      margin-bottom: 10px;
    }

    .left-section .tagline {
      font-size: 1.2rem;
      color:rgb(0, 0, 0); /* Light gray for better contrast */
      margin-bottom: 40px;
    }

    .card {
      background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white for readability */
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      max-width: 700px;
      max-height: 90vh;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .card h2 {
      font-size: 1.8rem;
      font-weight: 600;
      color: #333;
    }

    .card p {
      font-size: 1rem;
      color: #555;
      line-height: 1.6;
    }

    .dots {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-top: 20px;
    }

    .dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background-color: #ccc;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .dot.active {
      background-color: #0066ff;
    }

    .button-wrapper {
      display: flex;
      justify-content: flex-end;
      margin-top: 20px;
    }

    button {
      background-color: #0066ff;
      color: white;
      border: none;
      padding: 12px 28pt;
      border-radius: 30px;
      font-size: 1rem;
      cursor: pointer;
      transition: 0.3s ease;
      font-weight: 600;
    }

    button:hover {
      background-color: #004ec2;
      transform: translateY(-2px);
    }

    .back-button {
      position: absolute;
      top: 20px;
      left: 20px;
      background-color: transparent;
      border: none;
      color:rgb(0, 0, 0); /* Changed to white for visibility */
      font-size: 30px;
      cursor: pointer;
    }

    .back-button:hover {
      background-color: transparent;
      /* text-decoration: underline; */
    }

    @media (max-width: 900px) {
      .page {
        flex-direction: column;
      }
      .left-section {
        width: 100%;
      }
      .card {
        max-width: 100%;
        margin: 0 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container" id="container">
    <!-- Page 1 -->
    <div class="page" id="page1">
      <div class="left-section">
        <h1>DocApp</h1>
        <p class="tagline">Your health partner</p>
        <div class="card">
          <h2>Book Doctor Appointments With Ease</h2>
          <p>Use DocApp to quickly find certified doctors, check their availability, and book appointments—all from the comfort of your home.</p>
          <p>From general consultations to specialists, we help you connect with the right doctor and save your time.</p>
          <div class="dots">
            <span class="dot active" onclick="showPage(1)"></span>
            <span class="dot" onclick="showPage(2)"></span>
            <span class="dot" onclick="showPage(3)"></span>
          </div>
          <div class="button-wrapper">
            <button onclick="showPage(2)">Next</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Page 2 -->
    <div class="page" id="page2" style="display: none;">
      <div class="left-section">
        <button class="back-button" onclick="showPage(1)">←</button>
        <h1>DocApp</h1>
        <p class="tagline">Your health partner</p>
        <div class="card">
          <h2>Instant & Personalized Consultations</h2>
          <p>Experience smooth and tailored healthcare services. DocApp helps you manage your appointments effortlessly and get medical advice anytime.</p>
          <div class="dots">
            <span class="dot" onclick="showPage(1)"></span>
            <span class="dot active" onclick="showPage(2)"></span>
            <span class="dot" onclick="showPage(3)"></span>
          </div>
          <div class="button-wrapper">
            <button onclick="showPage(3)">Next</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Page 3 -->
    <div class="page" id="page3" style="display: none;">
      <div class="left-section">
        <button class="back-button" onclick="showPage(2)">←</button>
        <h1>DocApp</h1>
        <p class="tagline">Your health partner</p>
        <div class="card">
          <h2>Get Started Today</h2>
          <p>Create an account or login to access your personalized health dashboard, book doctors, and manage appointments easily.</p>
          <div class="dots">
            <span class="dot" onclick="showPage(1)"></span>
            <span class="dot" onclick="showPage(2)"></span>
            <span class="dot active" onclick="showPage(3)"></span>
          </div>
          <div class="button-wrapper">
            <button onclick="window.location.href='guest.php'">Get Started</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="jsforweb/homescript.js"></script>
</body>
</html>