<?php

namespace App\Controllers;

class LoginController {
    public function index() {
        // Check if the session is already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Load any error message
        $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        unset($_SESSION['error_message']); // Clear the error message

        // Load the login view
        include '../app/views/login.php';
    }

    public function login() {
        // Check if the session is already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Database connection
        $conn = \App\Database\Koneksi::getConnection();

        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['captcha'])) {
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $captcha = $_POST['captcha'];

            // Check if captcha is correct
            if ($captcha != $_SESSION['captcha']) {
                $_SESSION['error_message'] = "Captcha salah!";
                header('Location: /login');
                exit();
            }

            // Check username and password in the database
            $query = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 1) {
                $user = mysqli_fetch_assoc($result);
                if ($password == $user['password']) {
                    $_SESSION['username'] = $username;
                    header('Location: /home');
                    exit();
                } else {
                    $_SESSION['error_message'] = "Username atau password salah!";
                    header('Location: /login');
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "Username atau password salah!";
                header('Location: /login');
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Semua input harus diisi!";
            header('Location: /login');
            exit();
        }
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header('Location: /login');
        exit();
    }
}
