<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemesanan Tiket</title>
    <link rel="stylesheet" href="pesan.css"> 
</head>
<body>
    <h2>Data Pemesanan Tiket</h2>
    
    <?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'tiketdb';

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM pemesanan_tiket";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table class='data-table'>";
            echo "<tr><th>ID</th><th>Nama</th><th>Jumlah Tiket</th><th>Tanggal</th><th>File Upload</th><th>Aksi</th></tr>";

            while($row = $result->fetch_assoc()) {
                $filePath = htmlspecialchars($row['dokumen']);
                $fileName = basename($filePath);

                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['nama']) . "</td>
                        <td>" . htmlspecialchars($row['jumlah']) . "</td>
                        <td>" . htmlspecialchars($row['tanggal']) . "</td>
                        <td><a href='$filePath' target='_blank'>$fileName</a></td>
                        <td>
                            <a href='update.php?id=" . urlencode($row['id']) . "' class='edit-button'>Edit</a> 
                            <a href='hapus.php?id=" . urlencode($row['id']) . "' class='delete-button'>Hapus</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tidak ada data.</p>";
        }
    } else {
        echo "<p>Error dalam query: " . $conn->error . "</p>";
    }

    $conn->close();
    ?>
    
    <a href="pesan.php" class="submit-button">Kembali ke Form Pemesanan</a>
</body>
</html>
