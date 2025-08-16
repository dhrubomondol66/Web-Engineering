<?php
session_start();
include('db.php'); // Include the database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: Users_profile.php"); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['username'];

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: Doc-profile(user).php');
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];
} else {
    $doctor_id = ''; // Default to an empty string if not available
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = trim($_POST['paymentMethod']);
    $amount = trim($_POST['amount']);
    $doctor_id = trim($_POST['doctor_id']);

    if (empty($payment_method) || empty($amount) || empty($doctor_id)) {
        echo "All fields are required.";
    } else {
        // Validate doctor ID and availability
        $check_doctor_query = "SELECT id FROM doctors WHERE id = ?";
        $check_doctor_stmt = $mysqli->prepare($check_doctor_query);

        if (!$check_doctor_stmt) {
            die("SQL Error: " . $mysqli->error); // Handle query preparation failure
        }

        $check_doctor_stmt->bind_param('i', $doctor_id);
        $check_doctor_stmt->execute();
        $check_doctor_stmt->bind_result($doctor_id_result);
        $doctor_found = $check_doctor_stmt->fetch();
        $check_doctor_stmt->close(); // Close the statement to prevent "commands out of sync"

        if ($doctor_found) {
            // Insert payment into the database
            $insert_query = "INSERT INTO payments (user_id, doctor_id, amount, payment_method, payment_date) 
                 VALUES (?, ?, ?, ?, NOW())";
            $insert_stmt = $mysqli->prepare($insert_query);
        
            if (!$insert_stmt) {
                die("SQL Error: " . $mysqli->error); // Handle query preparation failure
            }
        
            $insert_stmt->bind_param('iiis', $user_id, $doctor_id, $amount, $payment_method);
        
            if ($insert_stmt->execute()) {
                // Redirect to receipt download
                header("Location: downloadReceipt.php?doctor_id=$doctor_id&user_id=$user_id");
                exit();
            } else {
                echo "Error processing payment: " . $insert_stmt->error;
            }
        
            $insert_stmt->close(); // Close the insert statement
        } else {
            echo "Invalid doctor ID.";
        }
        
    }
}


// Fetch payment history for the user
$payment_history_query = "
    SELECT p.payment_id, p.amount, p.payment_method, p.payment_date, d.username AS doctor_name
    FROM payments p
    JOIN doctors d ON p.doctor_id = d.id
    WHERE p.user_id = ?";
$history_stmt = $mysqli->prepare($payment_history_query);
$history_stmt->bind_param('i', $user_id);
$history_stmt->execute();
$payment_history_result = $history_stmt->get_result();

// Fetch total payments for each doctor
$total_payments_query = "
    SELECT d.username AS doctor_name, SUM(p.amount) AS total_payments
    FROM payments p
    JOIN doctors d ON p.doctor_id = d.id
    GROUP BY p.doctor_id";
$total_stmt = $mysqli->prepare($total_payments_query);
$total_stmt->execute();
$total_payments_result = $total_stmt->get_result();

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment and Download Receipt</title>
    <link rel="stylesheet" href="style/payment.css" />
    <link rel="stylesheet" href="style/navbar.css" />
</head>
<style>
    .center-container {
  align-items: center;

  background-color: #1c60e8;  /* optional background */
}
.center-container h1{
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}
.page-title {
  color: aliceblue;
  font-size: 4rem;
  
}
div a img {
  width: 40px;  /* adjust size */
  cursor: pointer;
  transition: transform 0.3s ease;
}

div a img:hover {
  transform: scale(1.1);
}

</style>
<body>
  <!-- Header -->
  <header class="header bg-blue">
    <nav class="navbar bg-blue">
      <div class="container flex">
        <!-- <div>
            <a href="userDashboard.php"><img src="imagesforweb/back.png" alt="back"></a>
        </div> -->
        <div class="DocApp_logo_left">
          <a href="userDashboard.php"><img src="imagesforweb/DocApp_Medical_Logo_Design.png" /></a>
        </div>

        <a href="userDashboard.php" class="navbar-brand"></a>
        <button type="button" class="navbar-show-btn">
          <img src="imagesforweb/ham-menu-icon.png" />
        </button>
        <div class="center-container">
            <h1 class="page-title">Payment</h1>
        </div>

        <div class="navbar-collapse bg-white">
          <button type="button" class="navbar-hide-btn">
            <img src="imagesforweb/close-icon.png" />
          </button>
          <!-- <ul class="navbar-nav">
              <li class="nav-item"><a href="#" data-page="services1.php" class="nav-link">Service</a></li>
              <li class="nav-item"><a href="#" data-page="bookDoctor1.php" class="nav-link">Doctors</a></li>
              <li class="nav-item"><a href="#" data-page="department1.php" class="nav-link">Departments</a></li>
              <li class="nav-item"><a href="#" data-page="blog1.php" class="nav-link">Blog</a></li>
              <li class="nav-item"><a href="#" data-page="info.php" class="nav-link">About</a></li>
          </ul> -->
        </div> 
          <div class="user-menu">
            <button class="user-btn" onclick="toggleDropdown()">
              <img src="imagesforweb/user_icon.jpg" alt="User Icon" class="user-icon" />
              <span class="username"><?php echo htmlspecialchars($username); ?></span>
              <span class="arrow" id="arrow">&#9662;</span> <!-- ▼ -->
            </button>

            <div class="dropdown" id="dropdown-menu">
              <a href="Users_profile.php">My Profile</a>
              <a href="edit_user_profile.php">Edit Profile</a>
              <a href="#">Report a bug</a>
              <a href="certificates.php">My Certificates</a>
              <a href="bookmarks.php">My Bookmarks</a>
              <hr />
              <button class="logout-btn" onclick="window.location.href='guest.php'">LOGOUT</button>
            </div>
          </div>
        </div>
      </div>
    </nav>
    
  </header>
  <!-- End of header -->
    <!-- <header>
        <h2>Payment and Download Receipt</h2>
    </header> -->
    <!-- Display success or error message -->
    <?php if (isset($success_message)): ?>
        <div style="color: green;"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div style="color: red;"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <br><br><form method="POST" action="payment.php"> <!-- Ensure the form submits to Payment.php -->
    <section class="selection">
        <h4>Select a payment method:</h4>
        <div class="payment-methods">
            <div class="payment-method">
                <input type="radio" id="bkash" name="paymentMethod" value="bKash" required>
                <label for="bkash">bKash</label>
            </div>

            <div class="payment-method">
                <input type="radio" id="nagad" name="paymentMethod" value="Nagad">
                <label for="nagad">Nagad</label>
            </div>

            <div class="payment-method">
                <input type="radio" id="visa" name="paymentMethod" value="Visa">
                <label for="visa">Visa</label>
            </div>

            <div class="payment-method">
                <input type="radio" id="mastercard" name="paymentMethod" value="MasterCard">
                <label for="mastercard">MasterCard</label>
            </div>

            <div class="payment-method">
                <input type="radio" id="rocket" name="paymentMethod" value="Rocket">
                <label for="rocket">Rocket</label>
            </div>
        </div>

        <div class="payment-amount">
            <label for="amount">Enter Payment (TK):</label>
            <input type="text" id="amount" name="amount" required>
        </div>

        <?php if (!empty($doctor_id)): ?>
            <input type="hidden" name="doctor_id" value="<?php echo htmlspecialchars($doctor_id); ?>">
        <?php else: ?>
        <p>Error: Doctor ID is missing. Please select a doctor first.</p>
        <?php endif; ?>


        <button type="submit" id="payment-btn">Make Payment</button>
    </section>
</form>

<section>
    <h4>Payment History</h4>
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Date</th>
                <th>Doctor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($payment_history_result->num_rows > 0) {
                while ($payment = $payment_history_result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$payment['payment_id']}</td>
                        <td>{$payment['amount']}</td>
                        <td>{$payment['payment_method']}</td>
                        <td>{$payment['payment_date']}</td>
                        <td>{$payment['doctor_name']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No payment history found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>
<section>
    <h4>Total Payments by Doctor</h4>
    <table>
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Total Payments</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($total_payments_result->num_rows > 0) {
                while ($total = $total_payments_result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$total['doctor_name']}</td>
                        <td>{$total['total_payments']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No payment data found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>


    <script>
        const paymentBtn = document.getElementById('payment-btn');
        const receiptSection = document.getElementById('receipt-section');

        paymentBtn.addEventListener('click', () => {
            const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
            const paymentAmount = document.getElementById('amount').value.trim();

            if (selectedPaymentMethod && paymentAmount !== '') {
        alert(`Payment Successful! You chose ${selectedPaymentMethod.value} as the payment method. Amount: ${paymentAmount} TK`);

                receiptSection.style.display = 'flex';
                // Trigger the file download (if needed)
                setTimeout(() => {
                    const doctorId = '<?php echo urlencode($doctor_id); ?>';
                    const downloadLink = document.createElement('a');
                    downloadLink.href = `downloadReceipt.php?doctor_id=${doctorId}`;
                    downloadLink.download = '';
                    downloadLink.click();
                }, 1000);
                window.location.href = 'downloadReceipt.php?doctor_id=<?php echo urlencode($doctor['id']); ?>';
            } else {
                alert('Please select a payment method and enter the payment amount before making the payment.');
            }
        });
    </script>

</body>

</html>