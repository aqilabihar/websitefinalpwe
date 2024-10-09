<?php
$host = "localhost";  // Host MySQL (biasanya localhost)
$user = "root";       // Username MySQL (default: root)
$pass = "";           // Password MySQL (kosong jika default)
$db   = "login_db";   // Nama database yang ingin dihubungkan

// Koneksi ke database MySQL
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if (!$conn) {
    // Jika gagal, tampilkan pesan error
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
