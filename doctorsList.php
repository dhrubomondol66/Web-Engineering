<?php
session_start();
require_once __DIR__ . '/db.php'; // should create $mysqli

// Resolve the logged-in doctor's username
$doctorUsername = null;

// 1) If you saved it in session during login:
if (!empty($_SESSION['username'])) {
    $doctorUsername = $_SESSION['username'];
}

// 2) Or fetch from DB using a stored doctor_id:
if (!$doctorUsername && !empty($_SESSION['doctor_id'])) {
    $stmt = $mysqli->prepare("SELECT username FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['doctor_id']);
    if ($stmt->execute()) {
        $stmt->bind_result($name);
        if ($stmt->fetch()) {
            $doctorUsername = $name;
        }
    }
    $stmt->close();
}

// 3) Fallback
if (!$doctorUsername) {
    $doctorUsername = 'Guest';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
    <link rel="stylesheet" href="style/doctorsList.css"> <!-- Link to your external CSS -->
</head>
<body>
    <!-- Navbar -->
<nav class="navbar">
    <a href="doctorDashboard.php" class="logo-link">
        <img src="imagesforweb/DocApp_Medical_Logo_Design.png" alt="DocApp Logo">
    </a>
    <div class="brand">DocApp</div>
    <ul>
        <li><a href="doctorDashboard.php">Dashboard</a></li>
        <li><a href="doctorsProfile1.php">My Profile</a></li>
        <li><a href="editDoctorProfile.php">Edit Profile</a></li>
        <li><a href="doctor_prescriptions.php">Prescriptions</a></li>

        <?php if ($doctorUsername !== 'Guest'): ?>
            <li class="dropdown">
                <a href="#">Hello, <?php echo htmlspecialchars($doctorUsername); ?> ▼</a>
                <div class="dropdown-content">
                    <a href="guest.php">Logout</a>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</nav>


    <div class="container">
        <h1>Registered Doctors List</h1>
        <div class="doctor-list">
            <?php
            // Database connection
            $mysqli = require __DIR__ . "/db.php"; // Include your database connection
            if (!$mysqli) {
                die("Database connection failed: " . $mysqli->connect_error);
            }

            // Query to fetch doctors from the database
            $sql = "SELECT * FROM doctors";
            $result = $mysqli->query($sql);

            // Check if there are any doctors in the database
            if (mysqli_num_rows($result) > 0) {
                while ($doctor = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="doctor-profile">
                        <h2><?php echo htmlspecialchars($doctor['username']); ?></h2><br>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($doctor['phone']); ?></p><br>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['email']); ?></p><br>
                        <p><strong>Specialization:</strong> <?php echo htmlspecialchars($doctor['specialist']); ?></p><br>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($doctor['address']); ?></p><br>
                        <div>
                            
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No doctors registered yet.</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>
