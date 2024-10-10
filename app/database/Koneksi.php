<?php
$host = 'localhost'; // Host database
$db = 'book_loan_schedule'; // Nama database
$dbuser = 'root'; // Username database
$dbpass = ''; // Password database

// Membuat koneksi ke database menggunakan mysqli
$mysqli = mysqli_connect($host, $dbuser, $dbpass, $db);

// Cek apakah koneksi berhasil
if (!$mysqli) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>