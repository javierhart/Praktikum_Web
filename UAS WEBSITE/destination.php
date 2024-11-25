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

// Pastikan parameter `id` tersedia di URL
if (isset($_GET['id'])) {
    $destination_id = (int)$_GET['id'];
} else {
    // Jika `id` tidak ditemukan, arahkan ke halaman utama
    header('Location: index.php');
    exit();
}


// Ambil data destinasi berdasarkan `id` menggunakan prepared statement
$stmt = $conn->prepare("SELECT * FROM `destinations` WHERE id = ?");
$stmt->bind_param("i", $destination_id);
$stmt->execute();
$result = $stmt->get_result();

// Jika data ditemukan
if ($result->num_rows > 0) {
    $destination_data = $result->fetch_assoc();
} else {
    // Jika data tidak ditemukan
    echo 'Destination not found.';
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kaltim Fun - <?php echo htmlspecialchars($destination_data['name']); ?></title>
  
</head>
<body>
  <style>
    /* General Reset */
body, h1, h2, p, ul, li, a, img {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
  color: #333;
  line-height: 1.6;
}

/* Navbar */
.profile-navbar {
  background-color: #0078FF;
  padding: 10px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  color: #fff;
}

.profile-navbar .logo {
  height: 40px;
}

.profile-navbar ul {
  list-style: none;
  display: flex;
  gap: 20px;
}

.profile-navbar a {
  text-decoration: none;
  color: #fff;
}

/* Banner */
.banner {
  width: 100%;
  height: 100vh;
  background-size: cover;
  background-position: center;
}

.banner-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

/* Content */
.content {
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.content h1 {
  font-size: 24px;
  margin-bottom: 10px;
  color: #0078FF;
}

.content h2 {
  font-size: 18px;
  margin: 15px 0;
  color: #0078FF;
}

.content p {
  margin-bottom: 15px;
}

.content ul {
  list-style-type: disc;
  margin: 0 0 15px 20px;
}

.location {
  display: flex;
  align-items: center;
  margin-top: 20px;
}

.location img {
  height: 20px;
  margin-right: 10px;
}

/* Footer */
footer {
  background-color: #0078FF;
  color: #fff;
  padding: 20px;
  text-align: center;
}

.footer-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  max-width: 800px;
  margin: 0 auto;
}

.footer-links a {
  color: #fff;
  margin: 0 10px;
  text-decoration: none;
}

.social-links img {
  height: 20px;
  margin: 0 5px;
}
.footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #007BFF;
  padding: 20px 40px;
  border-top: 1px solid #ddd;
  flex-wrap: wrap;
  text-align: center;
}

.footer-logo {
  flex: 1;
  display: flex;
  justify-content: center;
  height: 90px;
  margin: 0 auto;
}

.logo-placeholder {
  width: 80px;
  height: 80px;
  background-color: hwb(0 99% 1%);
  border-radius: 50%;
}

.footer-nav {
  flex: 2;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 5px;
  margin-left: 20px;
}

.footer-nav a {
  text-decoration: none;
  color: #fff;
  font-size: 16px;
}
.social-media {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.social-icons {
    display: flex;
    gap: 10px;
    margin-top: 5px;
}

.social-icons .icon-placeholder {
    width: 40px;
    height: 40px;
    background-color: hsl(0, 0%, 100%);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.social-icons .icon-placeholder img {
    width: 30px;
    height: 30px;
}
  
.copyright {
  margin-top: 15px;
  width: 100%;
  font-size: 14px;
  color: #fff;
}

.navbar {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    background:#007BFF;
    position: relative;
}

.logo img {
    height: 50px;
    margin: 0 auto;
}
.logo1 img {
    height: 90px;
    margin: 0 auto;
}
.nav-links {
    display: flex;
    list-style: none;
    gap: 20px;
    margin: 0 auto;
}

.nav-links li {
    display: inline-block;
}

.nav-links a {
    text-decoration: none;
    font-weight: bold;
    font-size: 18px;
    color: #fff;
    transition: color 0.3 ease-in-out
}

.nav-links a:hover {
    color: #333; 
}


  </style>
  <?php include 'navbar.php'; ?>

  <!-- Main Content -->
  <main>
    <div class="banner">
      <img src="uploaded_img/<?php echo htmlspecialchars($destination_data['image']); ?>" alt="<?php echo htmlspecialchars($destination_data['name']); ?>" class="banner-image">
    </div>

    <section class="content">
      <h1><?php echo htmlspecialchars($destination_data['name']); ?></h1>
      <p>
        <?php echo nl2br(htmlspecialchars($destination_data['description'])); ?>
      </p>

      <h2>Aktivitas Wisata:</h2>
      <ul>
        <?php
        // Assuming 'activities' is a comma-separated string
        $activities = explode(',', $destination_data['activities']);
        foreach($activities as $activity){
            echo '<li>' . htmlspecialchars(trim($activity)) . '</li>';
        }
        ?>
      </ul>

      <h2>Tips Berkunjung:</h2>
      <ul>
        <?php
        // Assuming 'tips' is a comma-separated string
        $tips = explode(',', $destination_data['tips']);
        foreach($tips as $tip){
            echo '<li>' . htmlspecialchars(trim($tip)) . '</li>';
        }
        ?>
      </ul>

      <div class="location">
  <a href=""><img style="height: 25px; margin-right: 10px;" src="WEB US ASET/location.svg" alt="Location Icon"></a>
  <p><?php echo htmlspecialchars($destination_data['location']); ?></p>
</div>
    </section>
  </main>

  <?php include 'footer.php'; ?>

</body>
</html>
