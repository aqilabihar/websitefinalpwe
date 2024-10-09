<?php

namespace App\Controllers;

class HomeController {
    public function index() {
        // Check if a session has already been started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['username'])) {
            header('Location: /login');
            exit();
        }

        include '../app/views/home.php';  // Load the home view
    }
}


