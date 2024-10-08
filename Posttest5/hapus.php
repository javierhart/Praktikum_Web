<?php

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'tiketdb';

$conn = new mysqli($host, $user, $password, $database);


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


$id = $_GET['id'];


$sql = "DELETE FROM pemesanan_tiket WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil dihapus";
} else {
    echo "Error: " . $conn->error;
}


$conn->close();


header("Location: edit.php");
exit();
?>
