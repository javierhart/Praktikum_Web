<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'tiketdb';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$nama = $_POST['nama'];
$jumlah = $_POST['jumlah'];
$tanggal = $_POST['tanggal'];


$sql = "INSERT INTO pemesanan_tiket (nama, jumlah, tanggal) VALUES ('$nama', '$jumlah', '$tanggal')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id; 
    header("Location: edit.php?id=$last_id"); 
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
