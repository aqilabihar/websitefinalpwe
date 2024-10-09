<?php

namespace App\Controllers;

class RegisterController {
    public function register() {
        // Check if the session is already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Registration logic
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = md5($_POST['password']); // Hash the password

                $conn = \App\Database\Koneksi::getConnection(); // Database connection
                $query = "INSERT INTO users (username, password, nama_pengguna) VALUES ('$username', '$password', '$username')";
                
                if (mysqli_query($conn, $query)) {
                    header('Location: /login');  // Redirect to login after successful registration
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Semua input harus diisi!";
            }
        }

        // Load the registration form view
        include '../app/views/register.php';
    }
}
