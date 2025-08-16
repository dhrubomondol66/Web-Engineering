<?php 
session_start();

// Include your database connection
include('db.php');  // Make sure you have this file and it's correctly connected

// Check if the user is logged in
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    $username = "Guest"; // Or redirect to the login page
}

// Get doctor ID from the URL
if (isset($_GET['doctor_id'])) {
    $doctor_id = mysqli_real_escape_string($mysqli, $_GET['doctor_id']); // Sanitize input
    $query = "
        SELECT d.username AS doctor_name, d.phone AS doctor_phone, d.specialist, ds.availability
        FROM doctors d
        LEFT JOIN doctor_schedule ds ON d.id = ds.doctor_id
        WHERE d.id = '$doctor_id'
    ";
    $result = mysqli_query($mysqli, $query);
    if ($result) {
        $doctor = mysqli_fetch_assoc($result);
        $doctor_name = $doctor['doctor_name'];  // Example field
        $doctor_phone = $doctor['doctor_phone'];
        $doctor_specialist = $doctor['specialist'];
        $doctor_availability = $doctor['availability'] ?? "No availability set.";
    } else {
        echo "Error fetching doctor details: " . mysqli_error($mysqli);
    }

    
    $doctor_map_link = "https://maps.app.goo.gl/PQ5x3WvdJmc8Uw8E7";

} else {
    $doctor_name = "Unknown Doctor";
    $doctor_phone = "Not Available";
    $doctor_specialist = "Not Available";
    $doctor_availability = "Not Available";
    $doctor_map_link = "#";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pdf</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="pdf.css" />
    <link rel="stylesheet" href="style/downloadReceipt.css" />
</head>

<body>

    <div class="download-container">
        <h2>Token/Receipt</h2>
        <form id="downloadForm">
            <!-- Patient Information -->
            <div id="invoice">
                <div class="patient-info">
                    <div class="info-label">Full Name:</div>
                        <div class="info-value"><?php echo htmlspecialchars($username); ?></div>
                
                </div>
                
                <div class="patient-info">
                    <div class="info-label">Phone Number:</div>
                    <div class="info-value">01*********</div>
                </div>

                <!-- Doctor Details -->
                <div class="info-label">Doctor Details:</div>
                <div class="doctor-info">
                    <div class="info-label">Name:</div>
                        <div class="info-value"><?php echo htmlspecialchars($doctor_name); ?></div>
                    </div>
                <div class="doctor-info">
                    <div class="info-label">Contact No:</div>
                    <div class="info-value"><?php echo htmlspecialchars($doctor_phone); ?></div>
                </div>
                <div class="doctor-info">
                    <div class="info-label">Specialist:</div>
                    <div class="info-value"><?php echo htmlspecialchars($doctor_specialist); ?></div>
                </div>
                <div class="doctor-info">
                    <div class="info-label">Time Schedule:</div>
                    <div class="info-value"><?php echo htmlspecialchars($doctor_availability); ?></div>
                </div>
                <div class="doctor-info">
                    <div class="info-label">Google Map Link:</div>
                    <div class="info-value">https://maps.app.goo.gl/PQ5x3WvdJmc8Uw8E7</div>
                </div>
            </div>
        </form>

        <button type="button" class="download-btn" id="download">Download</button>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

        <script src="jsForWeb/downloadReceipt.js"></script>

        
    </div>
</body>

</html>