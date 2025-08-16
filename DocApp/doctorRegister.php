<?php
session_start();

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/db.php";

    if (!$mysqli) {
        die("Database connection failed: " . $mysqli->connect_error);
    }

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $mysqli->prepare("SELECT * FROM doctors WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user["password"])) {
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["otp"] = $user["otp"];
            $_SESSION["specialist"] = $user["specialist"];
            $_SESSION["address"] = $user["address"];

            header("Location: doctorDashboard.php");
            exit;
        } else {
            $is_invalid = true;
        }
    } else {
        die("Query error: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup Form</title>
    <link rel="stylesheet" href="style/docStyle.css" />
</head>
<body>
    <div class="wrapper">
        <div class="title-text">
            <div class="title login">Login Form</div>
            <div class="title signup">Signup Form</div>
        </div>
        <?php if ($is_invalid): ?>
            <div style="color: red; text-align: center; margin-bottom: 10px;">
                Invalid email or password
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION["error"])): ?>
            <div style="color: red; text-align: center; margin-bottom: 10px;">
                <?php echo htmlspecialchars($_SESSION["error"]); ?>
                <?php unset($_SESSION["error"]); ?>
            </div>
        <?php endif; ?>
        <div class="form-container">
            <div class="slide-controls">
                <input type="radio" name="slide" id="login" checked>
                <input type="radio" name="slide" id="signup">
                <label for="login" class="slide login">Login</label>
                <label for="signup" class="slide signup">Signup</label>
                <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
                <form action="doctorRegister.php" method="post" class="login">
                    <div class="field">
                        <input type="text" placeholder="Email Address" required name="email">
                    </div>
                    <div class="field">
                        <input type="password" placeholder="Password" required name="password">
                    </div>
                    <div class="pass-link"><a href="#">Forgot password?</a></div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Login">
                    </div>
                    <div class="signup-link">Not a member? <a href="">Signup now</a></div>
                </form>
                <form action="signupProcces(doc).php" method="post" class="signup">
                    <div class="field">
                        <input type="text" placeholder="Username" required name="username">
                    </div>
                    <div class="field">
                        <input type="text" placeholder="Phone" required name="phone">
                    </div>
                    <div class="field">
                        <input type="text" placeholder="Email Address" required name="email">
                    </div>
                    <div class="field">
                        <input type="password" placeholder="Password" required name="password">
                    </div>
                    <div class="field">
                        <input type="password" placeholder="Confirm Password" required name="password_confirmation">
                    </div>
                    <div class="field">
                        <input type="text" placeholder="OTP Number" required name="otp">
                    </div>
                    <div class="field">
                        <input type="text" placeholder="Specialist" required name="specialist">
                    </div>
                    <div class="field">
                        <input type="text" placeholder="Address" required name="address">
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Signup">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const loginText = document.querySelector(".title-text .login");
        const loginForm = document.querySelector("form.login");
        const loginBtn = document.querySelector("label.login");
        const signupBtn = document.querySelector("label.signup");
        const signupLink = document.querySelector("form .signup-link a");

        signupBtn.onclick = () => {
            loginForm.style.marginLeft = "-50%";
            loginText.style.marginLeft = "-50%";
        };
        loginBtn.onclick = () => {
            loginForm.style.marginLeft = "0%";
            loginText.style.marginLeft = "0%";
        };
        signupLink.onclick = () => {
            signupBtn.click();
            return false;
        };
    </script>
</body>
</html>