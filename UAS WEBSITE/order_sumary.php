<?php
session_start();

include 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the latest order of the user
$query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

// Check if an order is found
if ($result && mysqli_num_rows($result) > 0) {
    $order = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('No orders found!'); window.location.href='purchase_tickets.php';</script>";
    exit();
}

// If payment method form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

    // Update the order with payment method
    $update_payment_query = "UPDATE orders SET payment_method = '$payment_method' WHERE order_id = '{$order['order_id']}'";
    $update_payment_result = mysqli_query($conn, $update_payment_query) or die('query failed');

    if ($update_payment_result) {
        echo "<script>alert('Payment method saved successfully!'); window.location.href='index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to save payment method. Please try again later.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaltim Fun - Order Summary</title>
    <link rel="stylesheet" href="order_sumary.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>
        <h1 class="title">ORDER SUMMARY</h1>
        <div class="order-summary">
            <form action="" method="POST">
                <!-- Order Number -->
                <label for="order-number">Order Number</label>
                <input type="text" id="order-number" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>" readonly>

                <!-- Buyer Email -->
                <label for="buyer-email">Buyer Email</label>
                <input type="email" id="buyer-email" name="email" value="<?php echo htmlspecialchars($order['email']); ?>" readonly>

                <!-- Order Details -->
                <h2>Order Details</h2>
                <div class="order-details">

                    <?php 

                    $json_string = $_SESSION['selected_tickets'];
                    $selected_tickets = json_decode($json_string, true);
                    foreach ($selected_tickets as $ticket) 
                    ?>

                    <div class="order-item">
                        <?php foreach ($selected_tickets as $ticket): ?>
                        <span><?php echo htmlspecialchars($ticket['name']); ?></span>
                        <span>IDR <?php echo number_format($ticket['price'], 0, ',', '.'); ?></span>
                        <?php endforeach; ?>
                    </div>
                    
                </div>

                <!-- Subtotal -->
                <h2>Order Summary</h2>
                <div class="order-summary">
                    <label for="subtotal">Subtotal</label>
                    <input type="text" id="subtotal" value="IDR <?php echo number_format($order['total_price'], 0, ',', '.'); ?>" readonly>
                </div>

                <!-- Payment Method -->
                <label for="payment-method">Payment Methods</label>
                <select id="payment-method" name="payment_method" required>
                    <option value="ovo">OVO</option>
                    <option value="gopay">GoPay</option>
                    <option value="dana">DANA</option>
                </select>

                <!-- Submit Button -->
                <button type="submit" class="send-button">Pay Now
                    <div class="paper-plane"><img src="WEB US ASET/paper-plane.svg" alt="Pay Now"></div>
                </button>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script>
        // SweetAlert for payment confirmation
        document.querySelector('form').addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                icon: 'success',
                title: 'Payment Successful!',
                text: 'Your ticket has been purchased. Check your email for the E-Ticket.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form after confirmation
                    this.submit();
                }
            });
        });
    </script>
</body>
</html>
