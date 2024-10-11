<?php

namespace App\Database;

class Koneksi {
    private static $conn;

    public static function getConnection() {
        if (self::$conn == null) {
            $host = "localhost";
            $user = "root";
            $pass = "";         
            $db   = "website_peminjaman";

            // Create the connection using mysqli
            self::$conn = new \mysqli($host, $user, $pass, $db);

            // Check if the connection was successful
            if (self::$conn->connect_error) {
                die("Koneksi gagal: " . self::$conn->connect_error);
            }
        }

        return self::$conn;  // Return the mysqli connection object
    }
}

// Initialize the connection when needed
Koneksi::getConnection();
