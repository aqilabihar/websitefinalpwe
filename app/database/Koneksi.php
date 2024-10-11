<?php

namespace App\Database;

<<<<<<< HEAD
class Koneksi {
    private static $conn;

    public static function getConnection() {
        if (self::$conn == null) {
            $host = "localhost";
            $user = "root";
            $pass = "";         
            $db   = "website_peminjaman";

            self::$conn = mysqli_connect($host, $user, $pass, $db);

            if (!self::$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
        }

        return self::$conn;
    }
}
=======
<<<<<<< Updated upstream
// Cek apakah koneksi berhasil
if (!$mysqli) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
=======
class Koneksi {
    private static $conn;

    public static function getConnection() {
        if (self::$conn == null) {
            $host = "localhost";
            $user = "root";
            $pass = "";         
            $db   = "website_peminjaman";

            // Buat koneksi dengan menggunakan mysqli
            self::$conn = new \mysqli($host, $user, $pass, $db);

            // Cek apakah koneksi berhasil
            if (self::$conn->connect_error) {
                die("Koneksi gagal: " . self::$conn->connect_error);
            } else {
                
            }
        }

        return self::$conn;  // Mengembalikan objek koneksi mysqli
    }
}

// Panggil untuk menginisialisasi koneksi
Koneksi::getConnection();
>>>>>>> Stashed changes
>>>>>>> MVC-Integration
