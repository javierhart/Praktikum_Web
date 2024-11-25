<?php
session_start();

@include 'config.php';


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

$user_id = $_SESSION['user_id'];


$selected_tickets = isset($_SESSION['selected_tickets']) ? $_SESSION['selected_tickets'] : [];


$total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;

if (empty($selected_tickets)) {
    echo "<script>alert('No tickets selected!'); window.location.href='purchase_tickets.php';</script>";
    exit();
}

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $customer_name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    // Update order with personal data
    $update_order_query = "UPDATE orders SET email = '$email', phone = '$phone', customer_name = '$customer_name', dob = '$dob', gender = '$gender' WHERE user_id = '$user_id' AND total_price = '$total_price' AND email = ''";
    $update_result = mysqli_query($conn, $update_order_query) or die('query failed');

    if ($update_result) {
        echo "<script>alert('Personal data saved successfully!'); window.location.href='order_sumary.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to save personal data. Please try again later.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Data</title>
    <link rel="stylesheet" href="personal.data.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>
        <section class="form-section">
            <h1>Personal Data</h1>

            <!-- Display Selected Tickets -->
            <h2>Your Tickets</h2>
            <ul>
                <?php 
                $json_string = $_SESSION['selected_tickets'];
                $selected_tickets = json_decode($json_string, true);
                ?>
                <?php foreach ($selected_tickets as $ticket): ?>
                    <li>
                        <?php echo htmlspecialchars($ticket['name']); ?> - IDR <?php echo number_format($ticket['price'], 0, ',', '.'); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Total Price: IDR <?php echo number_format($total_price, 0, ',', '.'); ?></strong></p>

            <!-- Form for Personal Data -->
            <form action="" method="POST">
                <div class="form-group">
                    <label for="email">EMAIL</label>
                    <input type="email" id="email" name="email" placeholder="Type Here..." required>
                </div>

                <div class="form-group">
                    <label for="phone">PHONE NUMBER</label>
                    <input type="tel" id="phone" name="phone" placeholder="Type Here..." required>
                </div>

                <div class="form-group">
                    <label for="name">NAME</label>
                    <input type="text" id="name" name="name" placeholder="Type Here..." required>
                </div>

                <div class="form-group">
                    <label for="dob">DATE OF BIRTH</label>
                    <input type="date" id="dob" name="dob" required>
                </div>

                <div class="form-group">
                    <label>GENDER</label>
                    <div class="gender-options">
                        <label><input type="radio" name="gender" value="man" required> Man</label>
                        <label><input type="radio" name="gender" value="woman" required> Woman</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="send-button">Send
                    <div class="paper-plane"><img src="WEB US ASET/paper-plane.svg" alt="Pay Now"></div>
                </button>
            </form>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
