<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$user_stmt = $mysqli->prepare("SELECT id, username, email, phone, created_at FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows === 0) {
    die("User not found");
}

$user_data = $user_result->fetch_assoc();
$user_stmt->close();

// Fetch payment history
$payment_stmt = $mysqli->prepare("SELECT payment_id, amount, payment_date FROM payments WHERE user_id = ? ORDER BY payment_date DESC");
$payment_stmt->bind_param("i", $user_id);
$payment_stmt->execute();
$payment_result = $payment_stmt->get_result();
$payment_stmt->close();

// Fetch prescriptions
$prescription_stmt = $mysqli->prepare("
    SELECT p.id, p.symptoms, p.medicines, p.dosage, p.notes, p.created_at, d.username AS doctor_name
    FROM prescriptions p
    JOIN doctors d ON p.doctor_id = d.id
    WHERE p.user_id = ?
    ORDER BY p.created_at DESC
");
$prescription_stmt->bind_param("i", $user_id);
$prescription_stmt->execute();
$prescription_result = $prescription_stmt->get_result();
$prescription_stmt->close();

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style/userprofile.css" />
</head>
<body>
    <nav class="navbar">
        <a href="userDashboard.php">
            <img src="imagesforweb/DocApp_Medical_Logo_Design.png" alt="back">
        </a>
        <div class="brand">DocApp</div>
        <ul>
            <li><a href="userDashboard.php">Dashboard</a></li>
            <li><a href="users_profile.php">My Profile</a></li>
            <li><a href="edit_user_profile.php">Edit Profile</a></li>
            <!-- <li><a href="appointment_history.php">Appointments</a></li> -->
            <li class="dropdown">
                <a href="#">Hello, <?php echo htmlspecialchars($user_data['username']); ?> ▼</a>
                <div class="dropdown-content">
                    <a href="guest.php">Logout</a>
                    <!-- <a href="change_password.php">Change Password</a> -->
                    <!-- <a href="settings.php">Settings</a> -->
                </div>
            </li>
        </ul>
    </nav>
    <header>
        <h1>User Profile</h1>
    </header>

    <div class="user-details">
        <h1><?php echo htmlspecialchars($user_data['username']); ?></h1>
        <hr>
        <h2>User Details:</h2>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user_data['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_data['phone']); ?></p>
        <p><strong>Account Created:</strong> <?php echo date('Y-m-d', strtotime($user_data['created_at'])); ?></p>
        <a href="edit_user_profile.php" class="edit-profile">Edit Profile</a><br>
        <a href="userDashboard.php" class="back-profile">Back</a>
    </div>

    <div class="profile-container">
        <!-- Payment History -->
        <div class="payment-history">
            <h2>Payment History:</h2>
            <?php if ($payment_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($payment = $payment_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $payment['payment_id']; ?></td>
                                <td>$<?php echo number_format($payment['amount'], 2); ?></td>
                                <td><?php echo date('Y-m-d H:i:s', strtotime($payment['payment_date'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No payment history available.</p>
            <?php endif; ?>
        </div>

        <!-- Prescription History -->
        <div class="prescription-history" style="margin-top: 30px;">
            <h2>Prescription History:</h2>
            <?php if ($prescription_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Symptoms</th>
                            <th>Medicines</th>
                            <th>Dosage</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pres = $prescription_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo date('Y-m-d', strtotime($pres['created_at'])); ?></td>
                                <td><?php echo htmlspecialchars($pres['doctor_name']); ?></td>
                                <td><?php echo htmlspecialchars($pres['symptoms']); ?></td>
                                <td><?php echo htmlspecialchars($pres['medicines']); ?></td>
                                <td><?php echo htmlspecialchars($pres['dosage']); ?></td>
                                <td><?php echo htmlspecialchars($pres['notes']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No prescriptions available.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>