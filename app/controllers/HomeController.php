<?php

namespace App\Controllers;

class HomeController {
    public function index() {
        session_start();

        if (!isset($_SESSION['username'])) {
            header('Location: /login');  // Redirect to login if not logged in
            exit();
        }

        include_once '../app/views/home.php';
    }
}

