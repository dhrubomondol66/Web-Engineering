<?php
include 'db.php'; // connect to MySQL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data (in your desired order)
    $email = $mysqli->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];
    $username = $mysqli->real_escape_string(trim($_POST['username']));
    $phone = $mysqli->real_escape_string(trim($_POST['phone']));

    // Validate required fields
    if (empty($email) || empty($password) || empty($username) || empty($phone)) {
        die("Please fill in all fields.");
    }

    // Check for existing email or username
    $check_sql = "SELECT id FROM users WHERE email = ? OR username = ?";
    $check_stmt = $mysqli->prepare($check_sql);
    $check_stmt->bind_param("ss", $email, $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        die("Email or username already exists.");
    }
    $check_stmt->close();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database in correct column order
    $insert_sql = "INSERT INTO users (username, email, phone, pwd) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insert_sql);
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param("ssss", $username, $email, $phone, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('Signup successful! Redirecting to login...'); window.location.href='login.php';</script>";
    } else {
        echo "Signup failed: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>DocApp - Sign Up</title>
  <link rel="stylesheet" href="style/signupstyle.css" />
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
  <div>
    <button onclick="window.location.href='guest.php'" class="back-button">
      <img src="imagesforweb/back.png" alt="">
    </button>
  </div>
  <div class="signup-container">
    <div class="signup-form">
      <a href="login.php" class="login-link">Already have an account? Sign in</a>
      <h2>Sign up to DocApp</h2>

      <form action="signup.php" method="POST">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" required placeholder="Email" />
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" required placeholder="Password" />
          <p>Password should be at least 8 characters, including a number and a lowercase letter.</p>
        </div>

        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" required placeholder="Username" />
        </div>

        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="tel" name="phone" id="phone" required placeholder="+8801XXXXXXXXX" />
        </div>

        <button type="submit">Sign Up</button>

        <p>By creating an account, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
      </form>
    </div>
  </div>
</body>
</html>
