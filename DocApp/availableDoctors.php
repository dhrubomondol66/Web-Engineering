<?php 
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
    <link rel="stylesheet" href="style/doctorsList.css"> <!-- External CSS -->
</head>
<body>

    <nav>
        <a href="userDashboard.php" class="back-btn">
            <img src="imagesforweb/back.png" alt="Back">
            <img src="imagesforweb/hospital-logo.jpg" alt="Logo">
        </a>
        <h1>Doctors List</h1>
    </nav>

    <section>
        <?php
        $sql = "
            SELECT d.id, d.username, d.phone, d.email, d.specialist, d.address, ds.availability
            FROM doctors d
            LEFT JOIN doctor_schedule ds ON d.id = ds.doctor_id
            ORDER BY d.id
        ";
        $result = $mysqli->query($sql);
        $index = 1;

        if ($result->num_rows > 0):
            while ($doctor = $result->fetch_assoc()):
                $divClass = "div" . $index;
        ?>
        <div class="<?php echo $divClass; ?>">
            <div class="<?php echo $divClass . '-1'; ?>">
                <h3><?php echo htmlspecialchars($doctor['username']); ?></h3>
                <a href="payment.php?doctor_id=<?php echo urlencode($doctor['id']); ?>">
                    <button>Payment</button>
                </a>
            </div>
            <div class="<?php echo $divClass . '-2'; ?>">
                <p><strong>Specialist:</strong> <?php echo htmlspecialchars($doctor['specialist']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($doctor['phone']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['email']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($doctor['address']); ?></p>
                <p><strong>Availability:</strong> <?php echo !empty($doctor['availability']) ? htmlspecialchars($doctor['availability']) : 'Not set'; ?></p>
            </div>
        </div>
        <?php
            $index++;
            endwhile;
        else:
            echo "<p style='text-align:center;color:#fff;'>No doctors registered.</p>";
        endif;
        ?>
    </section>

</body>
</html>
