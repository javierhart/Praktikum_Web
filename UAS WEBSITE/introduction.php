<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Hubungkan ke file konfigurasi database
@include 'config.php';

// Periksa koneksi ke database
if (!isset($conn)) {
    die('Database connection not established. Please check your config.php file.');
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
  echo "<script>
      alert('Anda harus login untuk mengakses halaman ini.');
      window.location.href = 'login.php';
  </script>";
  exit;
}


$user_id = $_SESSION['user_id'];

// Ambil semua destinasi dari database
$query = "SELECT * FROM destinations where type = 'destination'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Introduction</title>
  <link rel="stylesheet" href="Introduction.css">
  <link rel="stylesheet" href="navbar.css">
  <link rel="stylesheet" href="footer.css">
  
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<header>
<?php include 'navbar.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1></h1>
    </div>
  </section>
</header>

<main>
  <section class="hero">
    <img src="WEB US ASET/Ladang Budaya Tenggarong.jpg" alt="Hero Image">
  </section>

  <section class="destination">
    <?php
          // Tampilkan data destinasi dari database
          while ($destination = mysqli_fetch_assoc($result)) {
              ?>
    <article>
      <div class="image-wrapper">
        <img src="uploaded_img/<?php echo htmlspecialchars($destination['image']); ?>"
          alt="<?php echo htmlspecialchars($destination['name']); ?>">
      </div>
      <div class="content">
        <h3>
          <?php echo htmlspecialchars($destination['name']); ?>
        </h3>
        <p>
          <?php echo htmlspecialchars($destination['description']); ?>
        </p>
        <a href="destination.php?id=<?php echo $destination['id']; ?>">See More</a>
      </div>
    </article>
    <?php
          }
          ?>
  </section>
</main>

<?php include 'footer.php'; ?>
</body>

</html>