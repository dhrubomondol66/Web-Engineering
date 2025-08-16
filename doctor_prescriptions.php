<?php
session_start();
include 'db.php'; // defines $mysqli

// Ensure doctor is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: doctorRegister.php");
    exit;
}

$doctor_id = $_SESSION['user_id'];
$message = "";

// Handle form submission
if(isset($_POST['submit'])){
    $user_id = $_POST['user_id'];
    $symptoms = $_POST['symptoms'];
    $medicines = $_POST['medicines'];
    $dosage = $_POST['dosage'];
    $notes = $_POST['notes'];

    $stmt = $mysqli->prepare("INSERT INTO prescriptions (user_id, doctor_id, symptoms, medicines, dosage, notes, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iissss", $user_id, $doctor_id, $symptoms, $medicines, $dosage, $notes);

    if($stmt->execute()){
        $stmt->close();
        // Redirect doctor to dashboard after creation
        header("Location: doctorDashboard.php");
        exit(); // important to stop further execution
    } else {
        $message = "❌ Error: " . $stmt->error;
        $stmt->close();
    }
}

// Fetch eligible users (users who paid this doctor)
$query = "SELECT DISTINCT u.id, u.username
          FROM users u
          JOIN payments p ON u.id = p.user_id
          WHERE p.doctor_id = ?";

$stmt = $mysqli->prepare($query);
if (!$stmt) {
    die("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
}

$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$users_result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Prescription</title>
    <style>
    form { max-width: 600px; margin: 30px auto; font-family: Arial; }
    label { font-weight: bold; display: block; margin-top: 10px; }
    textarea, select { width: 100%; padding: 8px; margin-top: 5px; }
    button { margin-top: 15px; padding: 10px 20px; background-color: #1c60e8; color: white; border: none; border-radius: 5px; cursor: pointer; }
    button:hover { background-color: #154da3; }
    .message { margin: 15px auto; width: 600px; font-weight: bold; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Create Prescription</h2>
<?php if($message) echo "<div class='message'>{$message}</div>"; ?>

<form method="POST" action="">
    <label>Select User:</label>
    <select name="user_id" required>
        <?php while($row = $users_result->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['username']); ?></option>
        <?php endwhile; ?>
    </select>

    <label>Symptoms:</label>
    <textarea name="symptoms" required></textarea>

    <label>Medicines:</label>
    <textarea name="medicines" required></textarea>

    <label>Dosage:</label>
    <textarea name="dosage" required></textarea>

    <label>Notes:</label>
    <textarea name="notes"></textarea>

    <button type="submit" name="submit">Create Prescription</button>
</form>
</body>
</html>
