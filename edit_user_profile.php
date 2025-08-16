<?php
session_start();
$mysqli = include('db.php'); // Use correct variable

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user_data = $user_result->fetch_assoc();

// Process update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['phone'])) {
    $new_username = htmlspecialchars($_POST['username']);
    $new_phone = htmlspecialchars($_POST['phone']);

    $update_query = "UPDATE users SET username = ?, phone = ? WHERE id = ?";
    $update_stmt = $mysqli->prepare($update_query);
    $update_stmt->bind_param('ssi', $new_username, $new_phone, $user_id);

    if ($update_stmt->execute()) {
        $success_message = "Profile updated successfully!";

        // Refresh user data
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $user_result = $stmt->get_result();
        $user_data = $user_result->fetch_assoc();
    } else {
        $error_message = "Failed to update profile. Error: " . $update_stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="style/edit_user_profile.css">
</head>

<body>
    <style>
    
    </style>
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
    <div class="profile-container">
        <h1>Update Your Profile</h1>
        <?php if (isset($success_message)) echo "<p style='color:green;'>$success_message</p>"; ?>
        <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">New Username:</label><br>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required><br><br>

                <label for="phone">New Phone Number:</label><br>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($user_data['phone']); ?>" required><br>
            </div>
            <button type="submit" class="btn">Update</button>
            <br><br>
            <a href="users_profile.php" class="btn">Back to Profile</a>
        </form>
    </div>
</body>

</html>
