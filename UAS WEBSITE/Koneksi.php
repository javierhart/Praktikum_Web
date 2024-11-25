 <?php
import mysql.connector

koneksi = mysql.connector.connect(
    host="localhost",
    user="username",
    password="password",
    database="kaltimfun_db"
)

if koneksi.is_connected():
    print("Koneksi berhasil")
else:
    print("Koneksi gagal")
?>
