<?php

namespace App\Controllers;

use App\Models\Model;

class LoginController {
    public function index() {
        session_start();

        $error_message = "";

        if (isset($_SESSION['error_message'])) {
            $error_message = $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }

        include_once '../app/views/login.php';
    }

    public function login() {
        session_start();
        include_once '../app/database/connect.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['captcha'])) {
                $username = $_POST['username'];
                $password = md5($_POST['password']);
                $captcha = $_POST['captcha'];

                if ($captcha != $_SESSION['captcha']) {
                    $_SESSION['error_message'] = "Captcha salah!";
                    header('Location: /login');
                    exit();
                }

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
    }
}
