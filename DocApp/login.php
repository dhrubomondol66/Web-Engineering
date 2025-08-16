<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($usernameOrEmail) || empty($password)) {
        die("Please enter both username/email and password.");
    }

    // Query user by username or email
    $sql = "SELECT id, username, pwd FROM users WHERE username = ? OR email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $username, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;

            // Redirect to dashboard
            header("Location: userDashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }

    $stmt->close();
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>DocApp - Login</title>
  <link rel="stylesheet" href="style/loginstyle.css" />
  <style>
    .back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    background-color: transparent;
    border: none;
    padding: 5px;
    cursor: pointer;
    z-index: 10;
  }

  .back-button img {
    width: 25px; /* Adjust size as needed */
    height: auto;
  }

  </style>
</head>
<body>
  <button onclick="window.location.href='guest.php'" class="back-button">
    <img src="imagesforweb/back.png" alt="Back" />
  </button>
  <div class="login-form">
    <h2>Login to DocApp</h2>
    <form method="POST" action="login.php">
      <div class="form-group">
        <label for="username">Username or Email Address</label>
        <input type="text" id="username" name="username" placeholder="Enter your username or email" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required />
        <a href="#" class="forgot-password">Forgot password?</a>
      </div>
      <button type="submit">Login</button>
    </form>
    <a href="signup.php" class="signup-link">New to DocApp? Create an account</a>
    <?php if (!empty($error)): ?>
      <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <div style="text-align: center; margin-top: 20px;">
  <a href="doctorRegister.php" class="doc_link">Register as Doctor</a>
</div>

  </div>
  <div class="footer-links">
    <a href="#">Terms</a>
    <a href="#">Privacy</a>
    <a href="#">Docs</a>
    <a href="#">Contact DocApp Support</a>
    <a href="#">Manage cookies</a>
    <a href="#">Do not share my personal information</a>
  </div>
</body>
</html>

