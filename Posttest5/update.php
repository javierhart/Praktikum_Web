<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'tiketdb';


$conn = new mysqli($host, $user, $password, $database);


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


$id = isset($_POST['id']) ? $_POST['id'] : null;
$nama = isset($_POST['nama']) ? $_POST['nama'] : null;
$jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : null;
$tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : null;

if ($id === null) {
    echo "<p>ID tidak ditemukan.</p>";
    exit; 
}


$sql = "UPDATE pemesanan_tiket SET nama=?, jumlah=?, tanggal=? WHERE id=?";
$stmt = $conn->prepare($sql);


if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("siis", $nama, $jumlah, $tanggal, $id);


if ($stmt->execute()) {
  
    header("Location: edit.php?id=" . urlencode($id));
    exit();
} else {
    echo "Error: " . $stmt->error;
}


$stmt->close();


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
    
    <?php
    
    if ($id !== null) {
        $conn = new mysqli($host, $user, $password, $database);
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
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
        $conn->close();
    }
    ?>

    <form action="update.php" method="POST" class="form-edit">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
        
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
        
        <label for="jumlah">Jumlah Tiket:</label>
        <input type="number" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($row['jumlah']); ?>" required>
        
        <label for="tanggal">Tanggal Pemesanan:</label>
        <input type="date" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($row['tanggal']); ?>" required>
        
        <button type="submit">Simpan Perubahan</button>
        <a href="edit.php?id=<?php echo urlencode($row['id']); ?>" class="submit-button">Kembali</a> 
    </form>
</body>
</html>
