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

// Variabel default untuk fallback
$default_image = 'default.jpg';
$default_name = 'Unknown Destination';
$default_location = 'Unknown Location';

// Cek apakah parameter `id` tersedia di URL
if (isset($_GET['id'])) {
    // Jika `id` ada, ambil data destinasi berdasarkan `id`
    $destination_id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM `destinations` WHERE id = ?");
    $stmt->bind_param("i", $destination_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data tidak ditemukan
    if ($result->num_rows === 0) {
        echo 'Destination not found.';
        exit();
    }

    $destination_data = $result->fetch_assoc();
} else {
    // Jika `id` tidak ada, ambil semua data destinasi
    $query = "SELECT * FROM `destinations` where type = 'destination'";
    $result = $conn->query($query);

    if ($result->num_rows === 0) {
        echo 'No destinations found.';
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Things To Do.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <title><?php echo isset($destination_data['name']) ? htmlspecialchars($destination_data['name']) : 'Things To Do'; ?></title>
</head>
<body>
    <?php include 'navbar.php'; ?>
   <style>
   h1, h2 {
    text-align: center;
    color: #0078d4;
    margin-top: 40px;
    margin-bottom: 20px;
    
}
</style>

<?php if (isset($_GET['id'])): ?>
    <h2><?php echo htmlspecialchars($destination_data['name'] ?? 'Unknown'); ?></h2>
<?php else: ?>
    <h2>Daftar Tempat Wisata di Kalimantan Timur</h2>
<?php endif; ?>
    <main class="content">
        <section class="grid">
        <?php if (isset($_GET['id'])): ?>
                <!-- Jika parameter `id` ada, tampilkan satu destinasi -->
                <div class="card">
                    <img src="uploaded_img/<?php echo htmlspecialchars($destination_data['image'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($destination_data['name'] ?? 'Unknown'); ?>">
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($destination_data['name'] ?? 'Unknown'); ?></h3>
                        <p><?php echo htmlspecialchars($destination_data['location'] ?? 'Unknown Location'); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <!-- Jika parameter `id` tidak ada, tampilkan semua destinasi -->
                <?php while ($destination = $result->fetch_assoc()): ?>
                    <div class="card">
                        <a href="destination.php?id=<?php echo $destination['id']; ?>">
                            <img src="uploaded_img/<?php echo htmlspecialchars($destination['image'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($destination['name'] ?? 'Unknown'); ?>">
                        </a>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($destination['name'] ?? 'Unknown'); ?></h3>
                            <p><?php echo htmlspecialchars($destination['location'] ?? 'Unknown Location'); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>