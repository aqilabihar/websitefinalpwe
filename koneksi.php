<?php
$servername = "localhost";  // Nama host (biasanya localhost)
$username = "root";         // Nama pengguna MySQL
$password = "";             // Kata sandi MySQL (kosong jika default di localhost)
$dbname = "peminjaman_ruangan";  // Nama database yang ingin dihubungkan

// Membuat koneksi ke MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} 

echo "";

// Tutup koneksi jika sudah tidak digunakan (opsional)
// $conn->close();
?>
