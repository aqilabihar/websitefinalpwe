<?php

namespace App\Database;

class Koneksi {
    private static $conn;

    public static function getConnection() {
        if (self::$conn == null) {
            $host = "localhost";
            $user = "root";
            $pass = "";         
            $db   = "login_db";  


            self::$conn = mysqli_connect($host, $user, $pass, $db);

            if (!self::$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
        }

        return self::$conn;
    }
}
