<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'tiketdb';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id === null) {
    echo "<p>ID tidak ditemukan.</p>";
    exit; 
}

$query = "SELECT * FROM pemesanan_tiket WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<p>Data tidak ditemukan.</p>";
    exit;
}

$stmt->close();

// Proses pembaruan jika ada POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];

    // Debugging: Tampilkan nilai yang diterima
    echo "Nama: $nama <br>";
    echo "Jumlah: $jumlah <br>";
    echo "Tanggal: $tanggal <br>";

    // Variabel untuk menyimpan path dokumen
    $dokumen = $row['dokumen']; // Awalnya simpan dokumen yang ada

    if (isset($_FILES['dokumen']) && $_FILES['dokumen']['error'] == 0) {
        $target_dir = "uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $fileName = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES["dokumen"]["name"]));
        $target_file = $target_dir . $fileName;

        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($_FILES["dokumen"]["size"] > 10000000) {
            echo "File terlalu besar.";
            $uploadOk = 0;
        }

        if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "pdf") {
            echo "Hanya file JPG, JPEG, PNG & PDF yang diperbolehkan.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["dokumen"]["tmp_name"], $target_file)) {
                $dokumen = $target_file; // Update variabel dokumen dengan path baru
            } else {
                echo "Terjadi kesalahan saat mengupload file.";
            }
        }
    }

    // Update data ke database
    $sql = "UPDATE pemesanan_tiket SET nama=?, jumlah=?, tanggal=?, dokumen=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siisi", $nama, $jumlah, $tanggal, $dokumen, $id);

    // Debugging: Tampilkan kueri yang akan dijalankan
    if ($stmt->execute()) {
        // Redirect ke halaman edit dengan ID yang diperbarui
        header("Location: edit.php?id=" . urlencode($id));
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemesanan Tiket</title>
    <link rel="stylesheet" href="pesan.css"> 
</head>
<body>
    <h2>Edit Pemesanan Tiket</h2>
    
    <form action="" method="POST" class="form-edit" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
        
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
        
        <label for="jumlah">Jumlah Tiket:</label>
        <input type="number" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($row['jumlah']); ?>" required>
        
        <label for="tanggal">Tanggal Pemesanan:</label>
        <input type="date" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($row['tanggal']))); ?>" required>
        
        <label for="dokumen">Upload Dokumen:</label>
        <input type="file" id="dokumen" name="dokumen" accept=".jpg,.jpeg,.png,.pdf">

        <button type="submit">Simpan Perubahan</button>
        <a href="data.php" class="submit-button">Kembali</a> 
    </form>
</body>
</html>
