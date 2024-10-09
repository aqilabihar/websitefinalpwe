<?php

namespace App\Controllers;

use App\Models\Model;

class RegisterController {
    public function index() {
        // Update this to include the register page instead of the login page
        include_once '../app/views/register.php';
    }

    public function register() {
        session_start();
        include_once '../app/database/connect.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = md5($_POST['password']); // Consider using a more secure hashing function like password_hash()

                $query = "INSERT INTO users (username, password, nama_pengguna) VALUES ('$username', '$password', '$username')";
                if (mysqli_query($conn, $query)) {
                    // Redirect to login or another page after successful registration
                    header('Location: /login');
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "All fields are required!";
            }
        }

        include_once '../app/views/register.php';
    }
}
