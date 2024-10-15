<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'tiketdb';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];

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
                $dokumen = $target_file;

               
                $sql = "INSERT INTO pemesanan_tiket (nama, jumlah, tanggal, dokumen) VALUES ('$nama', '$jumlah', '$tanggal', '$dokumen')";
                if ($conn->query($sql) === TRUE) {
                    $last_id = $conn->insert_id;
                    header("Location: edit.php?id=$last_id");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Terjadi kesalahan saat mengupload file.";
            }
        }
    } else {
        echo "Tidak ada file yang diupload.";
    }
}

$conn->close();
?>
