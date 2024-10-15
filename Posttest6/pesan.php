<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Tiket</title>
    <link rel="stylesheet" href="pesan.css">
</head>
<body>
    <h2>Form Pemesanan Tiket</h2>
    <form action="toolpesan.php" method="POST" enctype="multipart/form-data" class="form-pesan">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda" required>

        <label for="jumlah">Jumlah Tiket:</label>
        <input type="number" id="jumlah" name="jumlah" placeholder="Berapa banyak tiket?" min="1" required>

        <label for="tanggal">Tanggal Pemesanan:</label>
        <input type="date" id="tanggal" name="tanggal" required>

        <label for="dokumen">Upload Identitas (KTP/SIM):</label>
        <input type="file" id="dokumen" name="dokumen" accept=".jpg, .jpeg, .png, .pdf" required>

        <button type="submit" class="submit-button">Pesan Tiket</button>
    </form>
</body>
</html>
