<?php
session_start();
include('connect.php'); // Koneksi ke database

// Reset error message on each load
$error_message = "";

// Check if there's any error message in the session (from previous login attempt)
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Clear the error after displaying it
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['captcha'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);  // Enkripsi password yang diinput dengan MD5
        $captcha = $_POST['captcha'];

        // Cek apakah captcha yang dimasukkan sesuai dengan captcha di sesi
        if ($captcha != $_SESSION['captcha']) {
            $_SESSION['error_message'] = "Captcha salah!";
            header('Location: login.php'); // Redirect to the same page with error
            exit();
        }

        // Cek username di database
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            // Bandingkan password hash dari database dengan hasil MD5 dari password yang diinput
            if ($password == $user['password']) {
                // Jika password cocok, set session dan redirect ke home
                $_SESSION['username'] = $username; // Simpan username di session
                header('Location: home.php'); // Redirect ke halaman home
                exit();
            } else {
                $_SESSION['error_message'] = "Username atau password salah!";
                header('Location: login.php'); // Redirect to the same page with error
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Username atau password salah!";
            header('Location: login.php'); // Redirect to the same page with error
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Semua input harus diisi!";
        header('Location: login.php'); // Redirect to the same page with error
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Captcha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Tinggi penuh layar */
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px; /* Lebar tetap */
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 95%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        #captchaSection {
            display: none; /* Sembunyikan captcha pada awalnya */
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <!-- Display Error Message (if any) -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required onblur="showCaptcha()">

            <!-- Captcha section akan tampil setelah password diisi -->
            <div id="captchaSection">
                <label for="captcha">Captcha:</label>
                <input type="text" id="captcha" name="captcha" required>
                <img src="captcha.php" alt="CAPTCHA Image" id="captchaImage"><br>
                <button type="button" onclick="refreshCaptcha()">Refresh Captcha</button>
            </div>

            <input type="submit" value="Login">
        </form>

        <!-- Bagian ini tetap ada: -->
        <p>Belum memiliki akun? <a href="register.php">Daftar di sini</a>.</p>

        <script>
            function showCaptcha() {
                var password = document.getElementById('password').value;
                if (password) {
                    document.getElementById('captchaSection').style.display = 'block'; // Tampilkan captcha jika password tidak kosong
                }
            }

            function refreshCaptcha() {
                // Refresh captcha image by reloading the src with a new query parameter
                document.getElementById('captchaImage').src = 'captcha.php?' + Math.random();
            }
        </script>
    </div>
</body>
</html>
