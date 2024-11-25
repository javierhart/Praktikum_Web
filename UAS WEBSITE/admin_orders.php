<?php
@include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit;
}

if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $delete_query = "DELETE FROM `orders` WHERE order_id = $delete_id";
    mysqli_query($conn, $delete_query) or die('Failed to delete order!');
    echo "<script>alert('Order deleted successfully!'); window.location.href='admin_orders.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="placed-orders">
    <h1 class="title">Placed Orders</h1>

    <div class="box-container">
        <?php
        $select_orders_query = "SELECT * FROM `orders`";
        $select_orders_result = mysqli_query($conn, $select_orders_query);

        if (mysqli_num_rows($select_orders_result) > 0) {
            while ($order = mysqli_fetch_assoc($select_orders_result)) {
                $user_id = $order['user_id'] ?? 'N/A';
                $placed_on = $order['placed_on'] ?? 'N/A';
                $email = $order['email'] ?? '';
                $total_price = $order['total_price'] ?? 0;
                $order_id = $order['order_id'] ?? '';

                // Decode dan ambil nama tempat dari ticket_name
                $ticket_name_data = isset($order['ticket_name']) ? json_decode($order['ticket_name'], true) : [];
                $place_names = array_map(function ($ticket) {
                    return htmlspecialchars($ticket['name'] ?? 'N/A');
                }, $ticket_name_data);
        ?>
        <div class="box">
            <p>User ID: <span><?php echo htmlspecialchars($user_id); ?></span></p>
            <p>Placed On: <span><?php echo htmlspecialchars($placed_on); ?></span></p>
            <p>Email: <span><?php echo htmlspecialchars($email); ?></span></p>

            <h2>Order Details:</h2>
            <div class="order-details">
                <?php if (!empty($place_names)): ?>
                    <ul>
                        <?php foreach ($place_names as $place): ?>
                            <li><?php echo $place; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No places found for this order.</p>
                <?php endif; ?>
            </div>

            <p>Total Price: <span>Rp.<?php echo number_format($total_price, 0, ',', '.'); ?></span></p>
            <a href="admin_orders.php?delete=<?php echo $order_id; ?>" 
               class="delete-btn" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
        </div>
        <?php
            }
        } else {
            echo '<p class="empty">No orders placed yet!</p>';
        }
        ?>
    </div>
</section>

<script src="js/admin_script.js"></script>
</body>
</html>
