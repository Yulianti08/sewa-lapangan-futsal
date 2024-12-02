<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "lapangan_futsal";

// Membuat koneksi
$conn = new mysqli("localhost", "root", "", "SEWA");

// Mengecek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    echo "Koneksi berhasil!";
}
?>
