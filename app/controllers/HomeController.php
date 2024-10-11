<?php

namespace App\Controllers;

class HomeController {
    public function index() {
        // Start the session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the user is logged in by checking the 'username' session key
        if (!isset($_SESSION['username'])) {
            // Redirect to the login page if not authenticated
            header('Location: /login');
            exit();  // Ensure no further code is executed after the redirect
        }

        // Use a safer method to resolve file paths
        $viewPath = realpath(dirname(__DIR__) . '/views/home.php');

        if ($viewPath && file_exists($viewPath)) {
            include $viewPath;  // Load the home view if the file exists
        } else {
            // Handle the case where the view file does not exist
            echo "Error: Home view not found.";
        }
    }
}
