<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Users_profile.php"); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['username'];

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

function filterServices(array $services, $searchTerm) {
    if ($searchTerm === '') return $services;

    $searchTerm = strtolower($searchTerm);
    return array_filter($services, function ($item) use ($searchTerm) {
        return strpos(strtolower($item['label']), $searchTerm) !== false;
    });
}

// All services (recommended and premium)
$recommendedServices = [
    ['label' => 'Online Appointment Booking', 'link' => 'online.html'],
    ['label' => 'Doctor Consultation (In-person)', 'link' => 'offline.html'],
    ['label' => 'Prescription Upload & Review', 'link' => 'user_prescriptions.php'],
    ['label' => 'Health Checkup Packages', 'link' => 'packages.html'],
    ['label' => 'Lab Test Booking', 'link' => 'testBooking.html'],
    ['label' => 'Radiology Tests', 'link' => 'radiology.html'],
    ['label' => 'Vaccination Services', 'link' => 'vaccination.html'],
    ['label' => 'Emergency Services', 'link' => 'emergency.html'],
    ['label' => 'Home Sample Collection', 'link' => 'sampleCollection.html'],
    ['label' => 'Psychiatry (Mental Health)', 'link' => 'psychiatry.html'],
    ['label' => 'Medical Report Download', 'link' => 'report.html'],
    ['label' => 'Second Opinion Consultation', 'link' => 'opinionConsultation.html'],
    ['label' => 'Chronic Disease Management', 'link' => 'chronic.html'],
    ['label' => 'Post-Surgery Follow-up', 'link' => 'followUp.html'],
    ['label' => 'Medicine Delivery', 'link' => 'medicine.html'],
    ['label' => 'Health Tips', 'link' => 'tips.html'],
    ['label' => 'Disease Awareness', 'link' => 'awareness.html'],
    ['label' => 'Doctor Advice', 'link' => 'awarness.html'],
    ['label' => 'Nutrition & Diet', 'link' => 'diet.html'],
    ['label' => 'Mental Health', 'link' => 'mentalHealth.html'],
    ['label' => 'Fitness & Lifestyle', 'link' => 'fitness&lifestyle.html'],
    ['label' => 'Seasonal Health Precautions', 'link' => 'precasution.html'],
    ['label' => 'Medical News & Updates', 'link' => 'news&updates.html'],
    ['label' => 'Medical FAQs', 'link' => 'faqs.html'],
];

$premiumServices = [
    ['label' => 'Doctor Rating & Review', 'link' => 'rating&review.html'],
    ['label' => 'Health Tracker Integration', 'link' => 'healthTracker.html'],
    ['label' => 'In-app Chat Support', 'link' => 'support.html'],
    ['label' => 'Insurance Claim Assistance', 'link' => 'insurance.html'],
];

$filteredRecommended = filterServices($recommendedServices, $searchTerm);
$filteredPremium = filterServices($premiumServices, $searchTerm);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Services</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="style/services.css" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
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
  </style>
</head>
<body>
  
  <main>
    <nav class="nav-service">
      <h1>Services</h1>
    </nav>
    <div class="search-container">
      <input type="text" id="searchInput" onkeyup="filterServices()" placeholder="Search for services...">
    </div>
    <section class="services-section">
      <div>
        <h2>Recommended Medical Services</h2>
        

        <div class="service-list">
          <?php if (count($filteredRecommended) > 0): ?>
            <?php foreach ($filteredRecommended as $service): ?>
              <a href="<?= htmlspecialchars($service['link']) ?>" onclick="windows">
                <?= htmlspecialchars($service['label']) ?>
              </a>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No recommended services found.</p>
          <?php endif; ?>
        </div>
      </div>

      <div>
        <h2>Optional Premium Services</h2>
        <div class="service-list">
          <?php if (count($filteredPremium) > 0): ?>
            <?php foreach ($filteredPremium as $service): ?>
              <a href="<?= htmlspecialchars($service['link']) ?>">
                <?= htmlspecialchars($service['label']) ?>
              </a>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No premium services found.</p>
          <?php endif; ?>
        </div>
      </div><br><hr><br>
    </section>
  </main>
  <script>
    function filterServices() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const serviceLists = document.querySelectorAll('.service-list');

      serviceLists.forEach(list => {
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
