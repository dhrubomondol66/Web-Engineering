<?php 
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: Users_profile.php"); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['username'];
// Get the department from query string, if set
$department = isset($_GET['specialist']) ? $mysqli->real_escape_string($_GET['specialist']) : '';
$searchTerm = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';
$is_logged_in = isset($_SESSION['user_id']);
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Doctors</title>
  <link rel="stylesheet" href="style/bookDoctor.css" />
  <!-- <link rel="stylesheet" href="style/navbar.css"> -->
  <style>
  </style>
</head>
<body>
  <!-- Header -->
  
  <!-- End of header -->
<?php
include('db.php');

$specialist = isset($_GET['specialist']) ? $_GET['specialist'] : '';

$query = "SELECT * FROM doctors";
if ($specialist) {
    $specialist = $mysqli->real_escape_string($specialist);
    $query .= " WHERE specialist = '$specialist'";
}

$result = $mysqli->query($query);
?>
  <!-- Filter Links -->
  <div class="department-filters">
    <br><br><h1 class="nav-title----">Doctors</h1><br><hr>
    <span>Filter by Disease:</span><br>
    <?php
$departments = [
  'Fever', 'Kedney', 'Heart', 'Skin', 'ENT',
  'Orthopedics', 'Gynecology', 'Neurology', 'Ophthalmology',
  'Psychiatry', 'Urology', 'Gastroenterology', 'Oncology',
  'Dentistry', 'Pulmonology'
];

$current = $department;

// "All" link
echo '<a href="bookDoctor1.php?partial=1"' . ($current === '' ? ' class="active filter-link"' : ' class="filter-link"') . '>All</a>';

foreach ($departments as $dept) {
    $class = ($dept === $current) ? ' class="active filter-link"' : ' class="filter-link"';
    echo ' <a href="bookDoctor1.php?specialist=' . urlencode($dept) . '&partial=1"' . $class . '>' . htmlspecialchars($dept) . '</a>';
}
?>
    <!-- Search Form -->
<form method="GET" class="search-form" action="bookDoctor1.php">
  <?php if (!empty($department)) echo '<input type="hidden" name="specialist" value="'.htmlspecialchars($department).'">'; ?>
  <input type="text" name="search" placeholder="Search by name or specialist" value="<?php echo htmlspecialchars($searchTerm); ?>">
  <button type="submit">Search</button>
</form>
  </div>

  <section class="doctor-section">

    <?php
    // Fetch doctors with their availability entries
    $sql = "
      SELECT d.id, d.username, d.phone, d.email, d.specialist, d.address, ds.availability
      FROM doctors d
      LEFT JOIN doctor_schedule ds ON d.id = ds.doctor_id
    ";

    $conditions = [];

    if (!empty($department)) {
      $conditions[] = "d.specialist LIKE '%$department%'";
    }

    if (!empty($searchTerm)) {
      $conditions[] = "(d.username LIKE '%$searchTerm%' OR d.specialist LIKE '%$searchTerm%')";
    }

    if (!empty($conditions)) {
      $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY d.username ASC";

    $result = $mysqli->query($sql);

    // Group by doctor id
    $doctors = [];

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        if (!isset($doctors[$id])) {
          $doctors[$id] = [
            'id' => $id,
            'username' => $row['username'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'specialist' => $row['specialist'],
            'address' => $row['address'],
            'availability' => [],
          ];
        }
        if ($row['availability']) {
          $doctors[$id]['availability'][] = $row['availability'];
        }
      }

      foreach ($doctors as $doc):
    ?>
      <div class="doctor-card" style="border: 1px solid #ccc; border-radius: 10px; padding: 20px; margin: 15px; background-color: #f9f9f9;">
  <div class="doctor-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h3 style="color: black; font-size: large; font-weight: bold; margin: 0;">
      <?php echo htmlspecialchars($doc['username']); ?>
    </h3>

    <!-- Doctor's Profile Button -->
    <?php if (isset($_SESSION['user_id'])): ?>
  <a href="doctorsProfile.php?id=<?php echo urlencode($doc['id']); ?>">
    <button class="profile-button">Doctor's Profile</button>
  </a>
<?php else: ?>
  <button class="profile-button">
    Doctor's Profile
  </button>
<?php endif; ?>

  </div>

  <div class="doctor-body" style="margin-top: 10px;">
    <p><strong>Specialist:</strong> <?php echo htmlspecialchars($doc['specialist']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($doc['phone']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($doc['email']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($doc['address']); ?></p>

    <p><strong>Availability:</strong></p>
    <?php if (!empty($doc['availability'])): ?>
      <div class="availability-row" style="display: flex; flex-wrap: wrap; gap: 10px;">
        <?php foreach ($doc['availability'] as $av): ?>
          <div class="schedule-box" style="background: #e8f0fe; padding: 10px; border-radius: 6px; text-align: center;">
            <span style="display: block; margin-bottom: 6px;"><?php echo htmlspecialchars($av); ?></span>
            <a href="payment.php?doctor_id=<?php echo urlencode($doc['id']); ?>&availability=<?php echo urlencode($av); ?>">
              <button class="pay-button" style="padding: 6px 12px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Book Now
              </button>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p style="color: #888;">Not Set</p>
    <?php endif; ?>
  </div>
</div>

    <?php
      endforeach;
    } else {
      echo '<p class="no-doctors">No doctors available for this moment.</p>';
    }
    ?>

  </section>
<!-- <script>
function showLoginAlert() {
    alert("Please log in to view doctor profiles.");
    window.location.href = "login.html";  // Change this if your login file is different
}
</script> -->

</body>
</html>
