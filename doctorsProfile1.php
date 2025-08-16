<?php
session_start();
require 'db.php';

// Check if doctor is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: doctorRegister.php");
    exit();
}

$doctor_id = $_SESSION['user_id']; // Use user_id from session

// Fetch doctor info
$stmt = $mysqli->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found in the database.";
    exit();
}

// Optional: store in session if needed
$_SESSION["email"] = $user["email"];
$_SESSION["specialist"] = $user["specialist"];
$_SESSION["address"] = $user["address"];

// Fetch availability
$stmt = $mysqli->prepare("SELECT availability FROM doctor_schedule WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$schedule_result = $stmt->get_result();

$availabilityList = [];
while ($row = $schedule_result->fetch_assoc()) {
    $availabilityList[] = $row['availability'];
}

$doctorUsername = $user['username'];
$doctorEmail = $user['email'];
$specialist = $user['specialist'] ?? "Specialist not set";
$address = $user['address'] ?? "Address not set";
//if (!$partial): ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="style/doctorsProfile.css" />
    <style>
       
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="doctorDashboard.php">
            <img src="imagesforweb/DocApp_Medical_Logo_Design.png" alt="back">
        </a>
        <div class="brand">DocApp</div>
        <ul>
            <li><a href="doctorDashboard.php">Dashboard</a></li>
            <li><a href="doctorsProfile1.php">My Profile</a></li>
            <li><a href="editDoctorProfile.php">Edit Profile</a></li>
            <li><a href="doctor_prescriptions.php">Prescriptions</a></li>
            <li class="dropdown">
                <a href="#">Hello, <?php echo htmlspecialchars($doctorUsername); ?> ▼</a>
                <div class="dropdown-content">
                    <a href="guest.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Header -->
    <header style="text-align:center; padding:20px 0;">
        <h1>Doctor Profile</h1>
    </header>

    <!-- Doctor Details -->
    <div class="doctor-details" style="padding: 10px 20px;">
        <h2><?php echo htmlspecialchars($doctorUsername); ?></h2>
        <hr>
        <h3>Doctor Details:</h3>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($doctorUsername); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($doctorEmail); ?></p>
        <p><strong>Specialist:</strong> <?php echo htmlspecialchars($specialist); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
        <a href="doctorDashboard.php" class="back-profile">Back</a>
    </div>

    <!-- Availability -->
    <div class="profile-container main-content" style="padding: 0 20px;">
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
