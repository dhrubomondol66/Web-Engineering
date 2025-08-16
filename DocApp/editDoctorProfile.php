<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: doctorsProfile.php");
    exit();
}

if (!isset($_SESSION['email'])) {
    die("Email not found in session. Please log in again.");
}

$doctorUsername = $_SESSION['username'];
$doctorEmail = $_SESSION['email'];
$specialist = $_SESSION['specialist'];
$address = $_SESSION['address'];

require 'db.php';

// Fetch existing availability
$stmt = $mysqli->prepare("
    SELECT ds.id, ds.availability 
    FROM doctor_schedule ds 
    JOIN doctors d ON ds.doctor_id = d.id 
    WHERE d.email = ?
");
$stmt->bind_param("s", $doctorEmail);
$stmt->execute();
$result = $stmt->get_result();

$availabilityList = [];
if ($result->num_rows > 0) {
    $availabilityList = $result->fetch_all(MYSQLI_ASSOC);
}
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newSpecialist = $_POST['specialist'];
    $newAddress = $_POST['address'];
    $availabilityInput = array_values($_POST['availability'] ?? []);
    $deleteAvailability = $_POST['delete_availability'] ?? '';

    $deleteAvailability = array_filter(explode(',', $deleteAvailability), fn($v) => $v !== '');
    $deleteAvailability = array_map('intval', $deleteAvailability);

    $mysqli->begin_transaction();

    try {
        // Update doctor details
        $stmt1 = $mysqli->prepare("UPDATE doctors SET username = ?, specialist = ?, address = ? WHERE email = ?");
        $stmt1->bind_param("ssss", $newUsername, $newSpecialist, $newAddress, $doctorEmail);
        $stmt1->execute();
        $stmt1->close();

        // Delete marked availability entries
        if (!empty($deleteAvailability)) {
            $placeholders = implode(',', array_fill(0, count($deleteAvailability), '?'));
            $types = str_repeat('i', count($deleteAvailability));
            $stmt2 = $mysqli->prepare("DELETE FROM doctor_schedule WHERE id IN ($placeholders)");
            $stmt2->bind_param($types, ...$deleteAvailability);
            $stmt2->execute();
            $stmt2->close();
        }

        // Get doctor ID
        $stmtGetDocId = $mysqli->prepare("SELECT id FROM doctors WHERE email = ?");
        $stmtGetDocId->bind_param("s", $doctorEmail);
        $stmtGetDocId->execute();
        $stmtGetDocId->bind_result($doctorId);
        $stmtGetDocId->fetch();
        $stmtGetDocId->close();

        if (!$doctorId) {
            throw new Exception("Doctor ID not found.");
        }

        // Insert new availability if not exists
        foreach ($availabilityInput as $availabilityValue) {
            $stmtCheck = $mysqli->prepare("SELECT id FROM doctor_schedule WHERE availability = ? AND doctor_id = ?");
            $stmtCheck->bind_param("si", $availabilityValue, $doctorId);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows === 0) {
                $stmt3 = $mysqli->prepare("INSERT INTO doctor_schedule (doctor_id, availability) VALUES (?, ?)");
                $stmt3->bind_param("is", $doctorId, $availabilityValue);
                $stmt3->execute();
                $stmt3->close();
            }

            $stmtCheck->close();
        }

        $mysqli->commit();

        // Update session
        $_SESSION['username'] = $newUsername;
        $_SESSION['specialist'] = $newSpecialist;
        $_SESSION['address'] = $newAddress;

        header("Location: doctorsProfile1.php");
        exit();
    } catch (Exception $e) {
        $mysqli->rollback();
        echo "Error updating profile: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Doctor Profile</title>
    <link rel="stylesheet" href="style/updateDocPro.css" />
    <script src="jsForWeb/updateDocPro.js">
        
    </script>
</head>
<body>

<header>
    <h1>Edit Doctor Profile</h1>
</header>

<div class="profile-container">
<form action="editDoctorProfile.php" method="POST">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($doctorUsername); ?>" required>

    <label for="specialist">Specialist</label>
    <input type="text" id="specialist" name="specialist" value="<?php echo htmlspecialchars($specialist); ?>" required>

    <label for="address">Address</label>
    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>

    <label>Availability</label>
    <ul class="availability-list">
    <?php if (!empty($availabilityList)): ?>
        <?php foreach ($availabilityList as $availability): ?>
            <li>
                <input type="text" name="availability[<?php echo htmlspecialchars($availability['id']); ?>]" value="<?php echo htmlspecialchars($availability['availability']); ?>" required />
                <button type="button" class="delete-availability" onclick="markForDeletion(this, <?php echo (int)$availability['id']; ?>)">Delete</button>
            </li><br>
        <?php endforeach; ?>
    <?php else: ?>
        <li>
            <input type="text" name="availability[]" placeholder="Enter availability" required />
        </li>
    <?php endif; ?>
    </ul>

    <input type="hidden" id="delete_availability" name="delete_availability" value="">

    <button type="button" onclick="addAvailability()">Add Availability</button><br><br>

    <!-- ✅ Fixed Update Button -->
    <button type="submit" name="update">Update</button><br><br>

    <!-- ✅ Fixed Back Button -->
    <a href="doctorsProfile1.php">
        <button type="button">Back</button>
    </a>
</form>
</div>

</body>
</html>
