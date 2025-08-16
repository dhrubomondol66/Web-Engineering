<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($_POST["username"])) {
    die("Username is required");
}

if (empty($_POST["password"])) {
    die("Password is required");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords do not match");
}

if (empty($_POST["phone"])) {
    die("Phone number is required");
}

if (empty($_POST["specialist"])) {
    die("Mention your specialization");
}

if (empty($_POST["address"])) {
    die("Mention your Address");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/db.php";

if (!$mysqli) {
    die("Database connection failed");
}

$sql = "INSERT INTO doctors (username, phone, email, password, otp, specialist, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sssssss", $_POST["username"], $_POST["phone"], $_POST["email"], $password_hash, $_POST["otp"], $_POST["specialist"], $_POST["address"]);

if ($stmt->execute()) {
    // ✅ Retrieve the newly inserted doctor to create session
    $new_email = $_POST["email"];
    $query = "SELECT * FROM doctors WHERE email = ?";
    $login_stmt = $mysqli->prepare($query);
    $login_stmt->bind_param("s", $new_email);
    $login_stmt->execute();
    $result = $login_stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION["doctor_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["otp"] = $user["otp"];
        $_SESSION["specialist"] = $user["specialist"];
        $_SESSION["address"] = $user["address"];

        header("Location: doctorDashboard.php");
        exit;
    } else {
        $_SESSION["error"] = "Failed to log you in after signup.";
        header("Location: doctorRegister.php");
        exit;
    }
} else {
    if ($mysqli->errno === 1062) {
        $_SESSION["error"] = "Email is already taken";
        header("Location: doctorRegister.php");
        exit;
    }
    $_SESSION["error"] = "An error occurred while processing your request. Please try again.";
    header("Location: doctorRegister.php");
    exit;
}
