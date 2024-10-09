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
            $username = $_POST['username'];
            $password = md5($_POST['password']);

            $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 1) {
                $_SESSION['username'] = $username;
                header('Location: /home');
                exit();
            } else {
                $_SESSION['error_message'] = 'Invalid username or password';
                header('Location: /login');
                exit();
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
    }
}
