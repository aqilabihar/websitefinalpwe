<?php
session_start();
session_destroy(); // Menghancurkan sesi
header('Location: login.php'); // Redirect ke halaman login
exit();
?>
