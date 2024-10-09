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
            height: 100vh; /* Full-screen height */
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
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
            display: none;
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

        <form method="POST" action="/login">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required onblur="showCaptcha()">

            <!-- Captcha section -->
            <div id="captchaSection">
                <label for="captcha">Captcha:</label>
                <input type="text" id="captcha" name="captcha" required>
                <img src="/captcha" alt="CAPTCHA Image" id="captchaImage"><br>
                <button type="button" onclick="refreshCaptcha()">Refresh Captcha</button>
            </div>

            <input type="submit" value="Login">
        </form>

        <p>Belum memiliki akun? <a href="/register">Daftar di sini</a>.</p>

        <script>
            function showCaptcha() {
                var password = document.getElementById('password').value;
                if (password) {
                    document.getElementById('captchaSection').style.display = 'block';
                }
            }

            function refreshCaptcha() {
                document.getElementById('captchaImage').src = '/captcha?' + Math.random();
            }
        </script>
    </div>
</body>
</html>
