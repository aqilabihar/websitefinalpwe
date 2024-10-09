<?php
session_start();
include('db_connect.php'); // Koneksi ke database

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['captcha'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);  // Enkripsi password dengan MD5
    $captcha = $_POST['captcha'];

    // Cek apakah captcha yang dimasukkan sesuai dengan captcha di sesi
    if ($captcha != $_SESSION['captcha']) {
        echo "Captcha salah!";
        exit();
    }

    // Cek username dan password di database
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        echo "Login sukses!";
    } else {
        echo "Username atau password salah!";
    }
} else {
    echo "Semua input harus diisi!";
}
?>
