<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("
    SELECT p.id, p.symptoms, p.medicines, p.dosage, p.notes, p.created_at, d.username AS doctor_name
    FROM prescriptions p
    JOIN doctors d ON p.doctor_id = d.id
    WHERE p.user_id = ?
    ORDER BY p.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$prescriptions = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Prescriptions</title>
    <style>
    /* ===== General Page Styling ===== */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f6f8;
}

/* ===== Navbar ===== */
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #075fd3;
    padding: 10px 20px;
    color: #fff;
    flex-wrap: wrap; /* makes it mobile-friendly */
}

.navbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.navbar img {
    height: 60px;
    width: 60px;
    object-fit: contain;
}

.navbar .brand {
    font-size: 20px;
    font-weight: bold;
}

.page-title {
    flex: 1;
    text-align: center;
    margin: 0;
    font-size: 20px;
    color: #fff;
}

.navbar ul {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.navbar ul li {
    position: relative;
}

.navbar ul li a {
    color: #fff;
    text-decoration: none;
    padding: 8px 12px;
    display: block;
}

.navbar ul li a:hover {
    background: #0b56b3;
    border-radius: 4px;
}

/* Dropdown */
.dropdown-content {
    display: none;
    position: absolute;
    background: #1553f0;
    min-width: 150px;
    box-shadow: 0px 4px 8px rgba(0,0,0,0.15);
    z-index: 1;
}

.dropdown-content a {
    color: #fff;
    padding: 10px;
    display: block;
    text-decoration: none;
}

.dropdown-content a:hover {
    background: #f1f1f1;
    color: #000;
}

.dropdown:hover .dropdown-content {
    display: block;
}

/* ===== Prescription Cards ===== */
.prescription {
    background: #fff;
    max-width: 800px; /* wider card */
    margin: 30px auto; /* more spacing from other elements */
    padding: 30px; /* more inner padding */
    border-radius: 10px;
    box-shadow: 0px 6px 14px rgba(0,0,0,0.12);
}

.prescription h3 {
    margin-top: 0;
    color: #075fd3;
    font-size: 18px; /* same font size */
}

.prescription p {
    margin: 10px 0;
    color: #555;
    font-size: 14px; /* same font size */
}

a.download {
    display: inline-block;
    margin-top: 12px;
    color: #fff;
    background: #166beb;
    padding: 10px 14px;
    border-radius: 5px;
    text-decoration: none;
}

a.download:hover {
    background: #0053c7;
}

    </style>
</head>
<body>
    <!-- Navbar -->
<nav class="navbar">
    <div class="navbar-left">
        <a href="userDashboard.php">
            <img src="imagesforweb/DocApp_Medical_Logo_Design.png" alt="back">
        </a>
        <div class="brand">DocApp</div>
    </div>

    <h2 class="page-title">My Prescriptions</h2>

    <ul>
        <li class="dropdown">
            <a href="#">Hello, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?> ▼</a>
            <div class="dropdown-content">
                <a href="guest.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>



<?php if($prescriptions->num_rows > 0): ?>
    <?php while($p = $prescriptions->fetch_assoc()): ?>
        <div class="prescription">
            <h3>Doctor: <?php echo htmlspecialchars($p['doctor_name']); ?></h3>
            <p><strong>Date:</strong> <?php echo date('Y-m-d', strtotime($p['created_at'])); ?></p>
            <p><strong>Symptoms:</strong> <?php echo htmlspecialchars($p['symptoms']); ?></p>
            <p><strong>Medicines:</strong> <?php echo htmlspecialchars($p['medicines']); ?></p>
            <p><strong>Dosage:</strong> <?php echo htmlspecialchars($p['dosage']); ?></p>
            <p><strong>Notes:</strong> <?php echo htmlspecialchars($p['notes']); ?></p>
            <a class="download" href="download_prescription.php?id=<?php echo $p['id']; ?>">Download</a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p style="text-align:center;">No prescriptions available.</p>
<?php endif; ?>
</body>
</html>
