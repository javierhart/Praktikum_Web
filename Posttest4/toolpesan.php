<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $jumlah = (int)$_POST['jumlah'];
    $tanggal = htmlspecialchars($_POST['tanggal']);

    $data = "Nama: $nama | Jumlah Tiket: $jumlah | Tanggal: $tanggal\n";

    $file = "pesanan.txt";

    $handle = fopen($file, "a");

    if (fwrite($handle, $data)) {
        echo "Pesanan berhasil disimpan!";
    } else {
        echo "Gagal menyimpan pesanan.";
    }

    fclose($handle);

    echo "<h2>Detail Pesanan Anda</h2>";
    echo "Nama: " . $nama . "<br>";
    echo "Jumlah Tiket: " . $jumlah . "<br>";
    echo "Tanggal Pemesanan: " . $tanggal . "<br>";
} else {
    echo "Tidak ada data yang dikirim!";
}
?>
