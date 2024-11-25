<?php
session_start();

@include 'config.php';


// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
  echo "<script>
      alert('Anda harus login untuk mengakses halaman ini.');
      window.location.href = 'login.php';
  </script>";
  exit;
}


$user_id = $_SESSION['user_id'];

// Fetch available destinations from the database
$destinations_query = "SELECT * FROM destinations";
$result = mysqli_query($conn, $destinations_query) or die('query failed');

// If the order button is pressed
// Jika tombol 'order' ditekan
if (isset($_POST['order'])) {
  echo "<pre>";
  echo "Selected Tickets (from POST): " . htmlspecialchars($_POST['selected_tickets']) . "\n";
  echo "Total Price (from POST): " . htmlspecialchars($_POST['total_price']) . "\n";
  echo "</pre>";

  // Periksa apakah 'selected_tickets' dan 'total_price' tersedia
  if (!empty($_POST['selected_tickets']) && !empty($_POST['total_price'])) {
      $selected_tickets = mysqli_real_escape_string($conn, $_POST['selected_tickets']);
      $total_price = mysqli_real_escape_string($conn, $_POST['total_price']);

      // Decode JSON selected_tickets dan periksa apakah decoding berhasil
      $decoded_tickets = $_POST['selected_tickets'];
      if ($decoded_tickets === null) {
          echo "<script>alert('Gagal decode JSON! Periksa data yang dikirimkan.');</script>";
          exit;
      }

      // Simpan tickets yang sudah didecode ke dalam session
      $_SESSION['selected_tickets'] = $decoded_tickets;
      $_SESSION['total_price'] = $total_price;

      // Insert tickets dan price ke dalam tabel 'orders'
      $placed_on = date('Y-m-d');

      $insert_order = "INSERT INTO orders (user_id, ticket_name, total_price, placed_on) VALUES ('$user_id', '$selected_tickets', '$total_price', '$placed_on')";
      $result_order = mysqli_query($conn, $insert_order) or die('query failed');

      if ($result_order) {
          session_write_close();  // Tutup sesi sebelum redirect untuk memastikan data disimpan
          header('location:personal_data.php');
          exit;
      }
  } else {
      echo "<script>alert('Selected tickets or total price is missing! Please try again.');</script>";
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Purchase Tickets</title>
  <link rel="stylesheet" href="purchase_tickets.css">
  <link rel="stylesheet" href="navbar.css">
  <link rel="stylesheet" href="footer.css">
</head>
<body>

<header>
    <?php include 'navbar.php'; ?>
</header>

<main>
  <section class="purchase-section">
    <h1>Purchase Tickets</h1>
    
    <?php
    if (!isset($_SESSION['user_id'])) {
        echo "<p>Please <a href='login.php'>log in</a> to purchase tickets.</p>";
    } else {
    ?>

    <section class="ticket-list">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($destination = $result->fetch_assoc()): ?>
          <article class="ticket-card">
            <img src="uploaded_img/<?php echo htmlspecialchars($destination['image']); ?>" alt="<?php echo htmlspecialchars($destination['name']); ?>">
            <div class="ticket-content">
              <h3><?php echo htmlspecialchars($destination['name']); ?></h3>
              <p><?php echo htmlspecialchars($destination['description']); ?></p>
              <div class="ticket-price">
                <span>IDR <?php echo number_format($destination['price'], 0, ',', '.'); ?></span>
                <button class="add-button" onclick="addToCart('<?php echo htmlspecialchars($destination['name']); ?>', <?php echo $destination['price']; ?>)">Add</button>
                <button class="remove-button" onclick="removeFromCart('<?php echo htmlspecialchars($destination['name']); ?>')">Remove</button>
              </div>
            </div>
          </article>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No destinations available.</p>
      <?php endif; ?>
    </section>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="order-form">
      <div class="summary">
        <span>Total (<span id="ticket-count">0</span> Ticket)</span>
        <span>IDR <span id="total-price">0</span></span>
        <input type="hidden" id="selected-tickets" name="selected_tickets">
        <input type="hidden" id="total_price" name="total_price">
        <button type="submit" name="order" class="order-button" disabled>Order</button>
      </div>
    </form>

    <?php
    }
    ?>
  </section>
</main>

<?php include 'footer.php'; ?>

<script>
  let selectedTickets = [];
  let totalPrice = 0;

  function addToCart(name, price) {
    selectedTickets.push({ name: name, price: price });
    totalPrice += price;
    updateCart();
  }

  function removeFromCart(name) {
    const index = selectedTickets.findIndex(ticket => ticket.name === name);
    if (index > -1) {
      totalPrice -= selectedTickets[index].price;
      selectedTickets.splice(index, 1);
    }
    updateCart();
  }

  function updateCart() {
    console.log('Selected Tickets:', JSON.stringify(selectedTickets));
    console.log('Total Price:', totalPrice);

    document.getElementById('ticket-count').innerText = selectedTickets.length;
    document.getElementById('total-price').innerText = totalPrice.toLocaleString('id-ID');
    document.getElementById('selected-tickets').value = JSON.stringify(selectedTickets);
    document.getElementById('total_price').value = totalPrice;

    // Debugging tambahan untuk memastikan form terisi sebelum submit
    if (selectedTickets.length > 0 && totalPrice > 0) {
        console.log("Form siap untuk disubmit dengan data: ", document.getElementById('selected-tickets').value, document.getElementById('total_price').value);
        document.querySelector('.order-button').disabled = false;
    } else {
        console.log("Form tidak lengkap, tidak dapat disubmit.");
        document.querySelector('.order-button').disabled = true;
    }
}

// Pastikan ketika pengguna klik tombol order, kita submit form dengan data yang ada di field hidden
document.querySelector('.order-button').addEventListener('click', function(event) {
    if (selectedTickets.length === 0 || totalPrice === 0) {
        event.preventDefault();
        alert('Tidak ada tiket yang dipilih!');
    }
  });


</script>

</body>
</html>
