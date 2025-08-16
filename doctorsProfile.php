<?php
session_start();

require 'db.php';

$partial = isset($_GET['partial']) && $_GET['partial'] == 1;

// 🚨 Validate doctor ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "No doctor specified.";
    exit();
}
$doctor_id = intval($_GET['id']);

// 🔍 Fetch doctor info
$stmt = $mysqli->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found in the database.";
    exit();
}

// 🧠 Store in session (optional)
$_SESSION["email"] = $user["email"];
$_SESSION["specialist"] = $user["specialist"];
$_SESSION["address"] = $user["address"];

// 🕐 Availability
$stmt = $mysqli->prepare("SELECT availability FROM doctor_schedule WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$schedule_result = $stmt->get_result();

$availabilityList = [];
while ($row = $schedule_result->fetch_assoc()) {
    $availabilityList[] = $row['availability'];
}

// 📋 Prepare doctor details
$doctorUsername = $user['username'];
$doctorEmail = $user['email'];
$specialist = $user['specialist'] ?? "Specialist not set";
$address = $user['address'] ?? "Address not set";

// 👇 Output starts here
//if (!$partial): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="style/doctorsProfile.css" /> <!-- Using the same CSS -->
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="userDashboard.php">
            <img src="imagesforweb/DocApp_Medical_Logo_Design.png" alt="back">
        </a>
        <div class="brand">DocApp</div>
        <ul>
            <!-- <li><a href="userDashboard.php">Dashboard</a></li> -->
            <!-- <li><a href="users_profile1.php">My Profile</a></li> -->
            <!-- <li><a href="edit_user_profile.php">Edit Profile</a></li> -->
            <!-- <li><a href="doctor_prescriptions.php">Prescriptions</a></li> -->
            <li class="dropdown">
                <a href="#">Hello, <?php echo htmlspecialchars($doctorUsername); ?> ▼</a>
                <div class="dropdown-content">
                    <a href="guest.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <header>
        <h1>Doctor Profile</h1>
    </header>
    <div class="doctor-details">
        <h2><?php echo htmlspecialchars($doctorUsername); ?></h2>
        <hr>
        <h3>Doctor Details:</h3>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($doctorUsername); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($doctorEmail); ?></p>
        <p><strong>Specialist:</strong> <?php echo htmlspecialchars($specialist); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
        <!-- <a href="editDoctorProfile.php" class="edit-profile">Edit Profile</a><br> -->
        <a href="userDashboard.php" class="back-profile">Back</a>
    </div>

    <div class="profile-container main-content">
        <div class="availability">
            <h2>Time Schedule:</h2>
            <?php if (!empty($availabilityList)): ?>
                <ul>
                <?php foreach ($availabilityList as $availability): ?>
                    <li><?php echo htmlspecialchars($availability); ?></li>
                <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No availability set.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
